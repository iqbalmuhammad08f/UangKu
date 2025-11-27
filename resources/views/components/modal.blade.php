@props([
    'id',
    'title' => '',
    'action' => '#',
    'method' => 'POST',
    'button' => 'Lanjutkan',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 backdrop-blur-sm"
         onclick="toggleModal('{{ $id }}')"></div>

    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6">

            <h3 class="text-lg font-bold text-gray-800 mb-4">
                {{ $title }}
            </h3>

            <form id="form-{{ $id }}" action="{{ $action }}" method="POST">
                @csrf
                @if (strtoupper($method) !== 'POST')
                    @method($method)
                @endif

                <div class="mb-4 text-gray-600">
                    {{ $slot }}
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="toggleModal('{{ $id }}')"
                            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                        Batal
                    </button>

                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        {{ $button }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
