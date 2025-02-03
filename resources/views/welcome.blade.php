<x-guest-layout>
    <div class="WelcomeBox">
        <div class="welcome-text">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-logo">
            <h1>Willkommen bei PlantPal!</h1>
            <p>Mit PlantPal kannst du deine Pflanzen intelligent überwachen.</p>

            <p id="install-text">PlantPal-App installieren:</p>
            <button id="install-button" style="display: none;">Install App</button>

            @if (Route::has('login'))
                <div class="mt-6">
                    @auth
                        <a href="{{ url('/installations') }}" class="DashboardClickl">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" id="login" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" id="register" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

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
</x-guest-layout>
