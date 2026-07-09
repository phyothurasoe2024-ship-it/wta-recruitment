<?php

namespace Tests\Feature;

use App\Models\CvApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CvApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_apply_page_is_accessible(): void
    {
        $response = $this->get('/apply');
        $response->assertOk();
        $response->assertSee('Join the WTA Team');
        $response->assertSee('Full name');
    }

    public function test_valid_application_is_stored(): void
    {
        Storage::fake('public');

        $photo    = UploadedFile::fake()->image('photo.jpg', 800, 600)->size(500);
        $nrcFile  = UploadedFile::fake()->create('nrc.pdf', 800, 'application/pdf');

        $response = $this->post('/apply', [
            'name'            => 'Aung Kyaw',
            'nrc'             => '12/ABC(N)123456',
            'address'         => '123 Main St, Yangon',
            'email'           => 'aung@example.com',
            'phone'           => '+95 9 123 456 789',
            'photo'           => $photo,
            'nrc_file'        => $nrcFile,
            'work_experience' => 'Two years at XYZ',
            'education'       => 'B.Sc. in Computer Science, University of Yangon (2020)',
            'why_join_wta'    => 'I admire WTA and want to contribute my skills to the team.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('cv_applications', [
            'name'  => 'Aung Kyaw',
            'nrc'   => '12/ABC(N)123456',
            'email' => 'aung@example.com',
        ]);

        $application = CvApplication::first();
        $this->assertNotNull($application->reference);
        $this->assertStringStartsWith('WTA-', $application->reference);
        $this->assertNotNull($application->photo_path);
        $this->assertNotNull($application->nrc_file_path);
        Storage::disk('public')->assertExists($application->photo_path);
        Storage::disk('public')->assertExists($application->nrc_file_path);
        $this->assertEquals('Two years at XYZ', $application->work_experience);
        $this->assertEquals('B.Sc. in Computer Science, University of Yangon (2020)', $application->education);
    }

    public function test_education_is_optional(): void
    {
        $response = $this->post('/apply', [
            'name'         => 'No Edu Person',
            'nrc'          => '12/ABC(N)654321',
            'address'      => 'Some address',
            'email'        => 'noedu@example.com',
            'phone'        => '+95 9 111 222 333',
            'why_join_wta' => 'I want to join the team and contribute.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cv_applications', ['nrc' => '12/ABC(N)654321']);
        $this->assertNull(CvApplication::where('nrc', '12/ABC(N)654321')->first()->education);
    }

    public function test_invalid_email_fails_validation(): void
    {
        $response = $this->post('/apply', [
            'name'         => 'Test Person',
            'nrc'          => '99/ABC(N)999999',
            'address'      => 'Test address',
            'email'        => 'not-an-email',
            'phone'        => '+95 9 123 456 789',
            'why_join_wta' => 'A sufficiently long reason for joining the company.',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('cv_applications', 0);
    }

    public function test_invalid_phone_fails_validation(): void
    {
        $response = $this->post('/apply', [
            'name'         => 'Test Person',
            'nrc'          => '99/ABC(N)999999',
            'address'      => 'Test address',
            'email'        => 'test@example.com',
            'phone'        => 'phone-with-letters',
            'why_join_wta' => 'A sufficiently long reason for joining the company.',
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_short_reason_fails_validation(): void
    {
        $response = $this->post('/apply', [
            'name'         => 'Test Person',
            'nrc'          => '99/ABC(N)999999',
            'address'      => 'Test address',
            'email'        => 'test@example.com',
            'phone'        => '+95 9 123 456 789',
            'why_join_wta' => 'short',
        ]);

        $response->assertSessionHasErrors('why_join_wta');
    }

    public function test_duplicate_nrc_is_rejected(): void
    {
        CvApplication::create([
            'reference'    => 'WTA-2026-0001',
            'name'         => 'Existing',
            'nrc'          => '12/ABC(N)123456',
            'address'      => 'X',
            'email'        => 'existing@example.com',
            'phone'        => '+95 9 111 111 111',
            'why_join_wta' => 'A sufficiently long reason for joining the company.',
            'status'       => CvApplication::STATUS_PENDING,
        ]);

        $response = $this->post('/apply', [
            'name'         => 'New Person',
            'nrc'          => '12/ABC(N)123456',
            'address'      => 'Different address',
            'email'        => 'new@example.com',
            'phone'        => '+95 9 222 222 222',
            'why_join_wta' => 'A sufficiently long reason for joining the company.',
        ]);

        $response->assertSessionHasErrors('nrc');
        $this->assertEquals(1, CvApplication::count());
    }

    public function test_thank_you_page_renders_reference(): void
    {
        $application = CvApplication::create([
            'reference'    => 'WTA-2026-0007',
            'name'         => 'Test',
            'nrc'          => '12/ABC(N)777777',
            'address'      => 'X',
            'email'        => 't@example.com',
            'phone'        => '+95 9 999 999 999',
            'why_join_wta' => 'Reason',
            'status'       => CvApplication::STATUS_PENDING,
        ]);

        $response = $this->get('/apply/thank-you/' . $application->reference);
        $response->assertOk();
        $response->assertSee('WTA-2026-0007');
        $response->assertSee('Test');
    }

    public function test_non_admin_cannot_access_admin_applications(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin/applications');
        $response->assertForbidden();
    }

    public function test_unauthenticated_cannot_access_admin(): void
    {
        $response = $this->get('/admin/applications');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_applications_list(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        CvApplication::create([
            'reference'    => 'WTA-2026-0001',
            'name'         => 'Test',
            'nrc'          => '12/ABC(N)111111',
            'address'      => 'X',
            'email'        => 't@example.com',
            'phone'        => '+95 9 999 999 999',
            'why_join_wta' => 'Reason',
            'status'       => CvApplication::STATUS_PENDING,
        ]);

        $response = $this->actingAs($admin)->get('/admin/applications');
        $response->assertOk();
        $response->assertSee('WTA-2026-0001');
    }

    public function test_admin_can_update_status_and_notes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $application = CvApplication::create([
            'reference'    => 'WTA-2026-0002',
            'name'         => 'Test',
            'nrc'          => '12/ABC(N)222222',
            'address'      => 'X',
            'email'        => 't@example.com',
            'phone'        => '+95 9 999 999 999',
            'why_join_wta' => 'Reason',
            'status'       => CvApplication::STATUS_PENDING,
        ]);

        $response = $this->actingAs($admin)->patch(
            "/admin/applications/{$application->id}",
            [
                'status'      => CvApplication::STATUS_INTERVIEW,
                'admin_notes' => 'Looks promising. Schedule for next week.',
            ]
        );

        $response->assertRedirect();
        $application->refresh();
        $this->assertEquals(CvApplication::STATUS_INTERVIEW, $application->status);
        $this->assertEquals('Looks promising. Schedule for next week.', $application->admin_notes);
        $this->assertEquals($admin->id, $application->reviewed_by);
        $this->assertNotNull($application->reviewed_at);
    }

    public function test_admin_dashboard_shows_counts(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        CvApplication::create([
            'reference'    => 'WTA-2026-0001',
            'name'         => 'A',
            'nrc'          => '1/1',
            'address'      => 'X',
            'email'        => 'a@example.com',
            'phone'        => '+95 1',
            'why_join_wta' => 'Reason',
            'status'       => CvApplication::STATUS_PENDING,
        ]);
        CvApplication::create([
            'reference'    => 'WTA-2026-0002',
            'name'         => 'B',
            'nrc'          => '2/2',
            'address'      => 'X',
            'email'        => 'b@example.com',
            'phone'        => '+95 2',
            'why_join_wta' => 'Reason',
            'status'       => CvApplication::STATUS_ACCEPTED,
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
        $response->assertSee('WTA-2026-0001');
        $response->assertSee('WTA-2026-0002');
    }
}
