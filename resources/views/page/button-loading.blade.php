<div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); text-align: center; padding-top: 45vh;">
    <div style="width: 40px; height: 40px; border: 4px solid #ddd; border-top: 4px solid #007bff; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 10px;"></div>
    <p>Chargement en cours...</p>
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    window.addEventListener('beforeunload', function() {
        document.getElementById('loading').style.display = 'block';
    });
</script>
