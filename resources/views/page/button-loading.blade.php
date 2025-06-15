<div
    id="global-loading"
    style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-60"
>
    <div class="text-center">
        <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <p class="mt-2 text-sm text-gray-600">Chargement en cours...</p>
    </div>
</div>

<script>
    window.addEventListener('beforeunload', function () {
        document.getElementById('global-loading').style.display = 'flex';
    });
</script>
