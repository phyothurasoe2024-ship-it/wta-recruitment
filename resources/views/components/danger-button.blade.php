<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-danger cursor-pointer']) }}>
    {{ $slot }}
</button>
