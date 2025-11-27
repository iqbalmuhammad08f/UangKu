@props(['message' => 'Hello World', 'type' => 'info'])

@php
    $colors = [
        'success' => 'bg-green-100 border border-green-400 text-green-700',
        'error' => 'bg-red-100 border border-red-400 text-red-700',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-500',
    ];

    $id = 'toast_'.uniqid();
@endphp

<div
    id="{{ $id }}"
    class="z-50 fixed bottom-5 right-5 flex items-center gap-3 px-4 py-3 rounded-lg shadow-md opacity-0 translate-x-5 transition-all duration-300 {{ $colors[$type] ?? $colors['info'] }}"
>

    <!-- Icon (opsional, biar minimalis tetap bagus) -->
    <div class="w-2 h-2 rounded-full bg-white"></div>

    <!-- Pesan -->
    <span class="text-sm">
        {{ $message }}
    </span>

    <!-- Tombol Close -->
    <button
        onclick="closeToast('{{ $id }}')"
        class="ml-2 text-white/80 hover:text-white text-lg leading-none"
    >
        &times;
    </button>
</div>

<script>
    function closeToast(id) {
        const toast = document.getElementById(id);
        if (!toast) return;

        toast.classList.remove('opacity-100', 'translate-x-0');
        toast.classList.add('opacity-0', 'translate-x-5');

        setTimeout(() => toast.remove(), 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('{{ $id }}');

        // Show animation
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-x-5');
            toast.classList.add('opacity-100', 'translate-x-0');
        }, 50);

        // Auto hide after 5 seconds
        setTimeout(() => {
            closeToast('{{ $id }}');
        }, 5000);
    });
</script>
