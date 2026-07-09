<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-secondary cursor-pointer disabled:opacity-50']) }}>
    {{ $slot }}
</button>
