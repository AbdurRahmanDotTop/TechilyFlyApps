<?php
// templates/footer.php
?>
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="<?= BASE_URL ?>index.php" class="logo" style="margin-bottom: 20px; display: inline-block;">
                    <?= htmlspecialchars($settings['site_name'] ?? 'Techily Fly Apps') ?>
                </a>
                <p style="color: var(--text-secondary); margin-bottom: 20px;">
                    Your ultimate destination for premium mobile and web applications. We build, showcase, and manage top-tier apps.
                </p>
                <div style="display: flex; gap: 15px; font-size: 1.5rem;">
                    <?php if (!empty($settings['social_facebook'])): ?>
                        <a href="<?= htmlspecialchars($settings['social_facebook']) ?>" target="_blank" style="color: var(--text-secondary);"><i class='bx bxl-facebook-circle'></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_twitter'])): ?>
                        <a href="<?= htmlspecialchars($settings['social_twitter']) ?>" target="_blank" style="color: var(--text-secondary);"><i class='bx bxl-twitter'></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_instagram'])): ?>
                        <a href="<?= htmlspecialchars($settings['social_instagram']) ?>" target="_blank" style="color: var(--text-secondary);"><i class='bx bxl-instagram'></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_linkedin'])): ?>
                        <a href="<?= htmlspecialchars($settings['social_linkedin']) ?>" target="_blank" style="color: var(--text-secondary);"><i class='bx bxl-linkedin-square'></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['social_github'])): ?>
                        <a href="<?= htmlspecialchars($settings['social_github']) ?>" target="_blank" style="color: var(--text-secondary);"><i class='bx bxl-github'></i></a>
                    <?php endif; ?>
                </div>
                
                <div style="margin-top: 20px; color: var(--text-secondary); font-size: 0.95rem;">
                    <?php if (!empty($settings['contact_phone'])): ?>
                        <p style="margin-bottom: 5px;"><i class='bx bx-phone' style="margin-right: 5px;"></i> <?= htmlspecialchars($settings['contact_phone']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($settings['contact_email'])): ?>
                        <p style="margin-bottom: 5px;"><i class='bx bx-envelope' style="margin-right: 5px;"></i> <?= htmlspecialchars($settings['contact_email']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($settings['contact_address'])): ?>
                        <p><i class='bx bx-map' style="margin-right: 5px;"></i> <?= htmlspecialchars($settings['contact_address']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>index.php">Home</a></li>
                    <li><a href="<?= BASE_URL ?>modules/apps/index.php">Browse Apps</a></li>
                    <li><a href="<?= BASE_URL ?>services.php">Our Services</a></li>
                    <li><a href="<?= BASE_URL ?>page.php/pricing">Pricing</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Legal</h4>
                <ul class="footer-links">
                    <li><a href="<?= BASE_URL ?>page.php/privacy-policy">Privacy Policy</a></li>
                    <li><a href="<?= BASE_URL ?>page.php/terms-conditions">Terms & Conditions</a></li>
                    <li><a href="<?= BASE_URL ?>page.php/refund-policy">Refund Policy</a></li>
                    <li><a href="<?= BASE_URL ?>page.php/faq">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Newsletter</h4>
                <p style="color: var(--text-secondary); margin-bottom: 15px;">Subscribe to get the latest app updates and news.</p>
                <form onsubmit="event.preventDefault(); alert('Thank you for subscribing!'); this.reset();" style="display: flex; gap: 10px;">
                    <input type="email" placeholder="Your Email Address" style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); flex: 1; outline: none;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 20px; border-radius: 8px;">Subscribe</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_name'] ?? 'Techily Fly Apps') ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top" aria-label="Back to Top">
    <i class='bx bx-up-arrow-alt'></i>
</button>

<!-- Main JS -->
<script src="<?= BASE_URL ?>assets/js/main.js?v=<?= filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/61f0d07fb9e4e21181bbeec3/1fqaastd0';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>
</html>
