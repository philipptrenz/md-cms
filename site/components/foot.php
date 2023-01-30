        </main>
        
        <footer class="py-4 md:p-2 md:fixed md:bottom-0 md:right-0 print:hidden">
            <ul class="text-right flex flex-row md:flex-col">
               
                <li class="flex-grow text-center md:text-right text-primary lowercase hover:opacity-75 active:opacity-50">
                    <a href="/impressum/">Impressum</a>
                </li>
                
                <li class="flex-grow text-center md:text-right text-primary lowercase hover:opacity-75 active:opacity-50">
                    <a href="/privacy/">Privacy</a>
                </li>

            </ul>
        </footer>

        <script src="/assets/js/alpinejs/core.min.js" defer></script>
        <script src="/assets/js/smooth-scroll/init.js" defer></script>
        <script src="/assets/js/smooth-scroll/core.min.js" async id="smooth-scroll"></script>

        <?php if ($config && $matomo = $config['matomo']): ?>
        <?php $disableCookies = in_array("disableCookies", $matomo) ? $matomo["disableCookies"] : false; ?>
        <script>
            var _paq = window._paq = window._paq || [];
            <?php if ($disableCookies): ?>
            _paq.push(['disableCookies']);
            <?php endif ?>
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="<?= rtrim($matomo["url"],"/").'/' ?>";
                _paq.push(['setTrackerUrl', u+'matomo.php']);
                _paq.push(['setSiteId', '<?= $matomo["id"] ?>']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
        <noscript><p><img src="<?= rtrim($matomo["url"],"/").'/' ?>matomo.php?idsite=<?= $matomo["id"] ?>&amp;rec=1" style="border:0;" alt="" /></p></noscript>
        <?php endif ?>

    </body>
</html>