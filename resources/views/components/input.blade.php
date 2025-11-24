@props([
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'label' => null,
    'icon' => null,
])

<div {{ $attributes -> class(['mb-5']) }}>

    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 text-sm font-medium mb-2 text-start">
            {{ $label }}
        </label>
    @endif

    <div class="relative">

        @if($icon)
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"

            class="
                w-full py-3 rounded-lg border border-gray-300
                focus:outline-none focus:ring-2 focus:ring-blue-500
                transition
                @if($icon) pl-10 @else pl-4 @endif
                @if($type === 'password') pr-10 @else pr-4 @endif
            "
            {{ $attributes }}
        >
        @if($type === 'password')
            <span
                class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400"
                onclick="togglePassword('{{ $name }}')"
            >
                <i id="eye-{{ $name }}" class="fa-solid fa-eye-slash"></i>
            </span>
        @endif

    </div>
</div>

@once
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById("eye-" + id);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endonce
