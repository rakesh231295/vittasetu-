<footer class="site-footer" id="contact">
    <div class="container">
        <div class="footer-panel">
            <div class="footer-cta">
                <div>
                    <span class="eyebrow">Need financial guidance?</span>
                    <h2>Let&apos;s build a smarter financial plan for your goals</h2>
                </div>
                <a href="contact.php" class="btn btn-primary">Get Consultation</a>
            </div>

            <div class="footer-grid">
                <div class="footer-brand-block">
                    <a href="#top" class="brand footer-brand" aria-label="Vittasetu footer logo">
                        <span class="brand-mark brand-logo-img"><img src="img/v-logo-removebg-preview.png" alt="Vittasetu logo"></span>
                    </a>
                    <p class="footer-brand-tagline">Trusted Financial Advisory</p>
                    <p>Trusted financial consulting and funding support with transparent advisory service for individuals and businesses.</p>
                    <div class="footer-trust-row">
                        <span><i class="fa-solid fa-shield-halved"></i> <strong>CA</strong> Led Advisory</span>
                        <span><i class="fa-solid fa-bolt"></i> <strong>Fast</strong> Support</span>
                        <span><i class="fa-solid fa-lock"></i> <strong>100%</strong> Secure</span>
                    </div>
                    <div class="footer-socials">
                        <a href="https://wa.me/919831040460" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="mailto:contact@vittasetu.co.in" aria-label="Email"><i class="fa-solid fa-envelope"></i></a>
                        <a href="tel:+919831040460" aria-label="Phone"><i class="fa-solid fa-phone"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <a href="index.php">Home</a>
                        <a href="about.php">About Us</a>
                        <a href="products.php">Our Products</a>
                        <a href="need-loan.php">Need Loans</a>
                        <a href="calculator.php">Calculator</a>
                        <a href="blog.php">Blog</a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Services</h3>
                    <div class="footer-links">
                        <a href="financial-consulting.php">Financial Consulting</a>
                        <a href="funding-solutions.php">Funding Solutions</a>
                        <a href="investment-wealth-management.php">Investment &amp; Wealth</a>
                        <a href="virtual-services.php">Virtual CFO</a>
                        <a href="real-estate-counsulting.php">Real Estate Advisory</a>
                    </div>
                </div>

                <div class="footer-column footer-contact-card">
                    <h3>Contact Us</h3>
                    <p><i class="fa-solid fa-location-dot"></i> 8 Beck Bagan Row, Park Circus, Kolkata - 700017</p>
                    <p><i class="fa-solid fa-phone"></i> <a href="tel:+919831040460">+91 9831040460</a></p>
                    <p><i class="fa-solid fa-envelope"></i> <a href="mailto:contact@vittasetu.co.in">contact@vittasetu.co.in</a></p>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-text-reset">&copy; <?php echo date('Y'); ?> Vittasetu Services Private Limited. All rights reserved.</p>
                <div class="footer-legal-links">
                    <a id="privacy" href="#privacy">Privacy Policy</a>
                    <a id="terms" href="#terms">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<a class="whatsapp-float" href="https://wa.me/919831040460" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
    <span>WhatsApp Us</span>
</a>

<a class="back-to-top" href="#top" aria-label="Back to top">
    <i class="fa-solid fa-arrow-up"></i>
</a>

<script src="js/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successAlert = document.querySelector('.form-alert-success');

        if (successAlert) {
            setTimeout(function () {
                successAlert.style.display = 'none';

                if (window.history.replaceState && window.location.search.indexOf('success=1') !== -1) {
                    var cleanUrl = window.location.pathname + window.location.hash;
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }, 5000);
        }
    });
</script>
</body>
</html>
