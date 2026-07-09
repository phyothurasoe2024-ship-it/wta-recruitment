<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary cursor-pointer']) }}>
    {{ $slot }}
</button>
