@extends('layout.mainLayout')

@section('content')
    <h1>PlantPal</h1>

    <h2>Willkommen, USERNAME!</h2>

    <p id="install-text">PlantPal-App installieren:</p>
    <button id="install-button" style="display: none;">Install App</button>

    @livewire('MQTT-livewire-send')

    @livewire('MQTT-livewire-receive')

    <script>
        let deferredPrompt;
        const installButton = document.getElementById('install-button');
        const installText = document.getElementById('install-text');

        function isInStandaloneMode() {
            return (window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone === true);
        }

        function updateUI() {
            if (isInStandaloneMode()) {
                installText.style.display = 'none';
                installButton.style.display = 'none';
            } else {
                if (window.localStorage.getItem('plantpal_installed') === 'true') {
                    installText.textContent =
                        'Die PlantPal-App ist bereits installiert. Öffnen Sie diese direkt auf Ihrem Gerät!';
                    installButton.style.display = 'none';
                } else {
                    installText.textContent = 'PlantPal-App installieren:';
                    installButton.textContent = 'Install App';
                    installButton.style.display = 'none';
                }
            }
        }

        function handleInstallButtonClick() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    deferredPrompt = null;
                });
            }
        }

        installButton.addEventListener('click', handleInstallButtonClick);

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredPrompt = event;
            installButton.style.display = 'block';
            installText.textContent = 'PlantPal-App installieren:';
            installButton.textContent = 'Install App';
        });

        window.addEventListener('appinstalled', () => {
            console.log('PWA wurde installiert');
            window.localStorage.setItem('plantpal_installed', 'true');
            location.reload();
        });
        updateUI();
    </script>
@endsection
