<?php
// contact.php
require_once __DIR__ . '/templates/header.php';
?>

<section class="section pt-0">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 15px;">Contact Us</h1>
            <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Have a question or want to work together? Get in touch with us using the details below or fill out the form.</p>
        </div>
        
        <div class="contact-grid">
            <!-- Contact Info -->
            <div>
                <div class="app-card" style="padding: 30px;">
                    <h3 style="margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Contact Information</h3>
                    
                    <ul style="list-style: none; padding: 0;">
                        <?php if (!empty($settings['contact_phone'])): ?>
                            <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px; color: var(--text-secondary);">
                                <i class='bx bx-phone' style="font-size: 1.5rem; color: var(--accent-primary);"></i>
                                <?= htmlspecialchars($settings['contact_phone']) ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['contact_email'])): ?>
                            <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px; color: var(--text-secondary);">
                                <i class='bx bx-envelope' style="font-size: 1.5rem; color: var(--accent-primary);"></i>
                                <?= htmlspecialchars($settings['contact_email']) ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['contact_address'])): ?>
                            <li style="margin-bottom: 15px; display: flex; align-items: flex-start; gap: 10px; color: var(--text-secondary);">
                                <i class='bx bx-map' style="font-size: 1.5rem; color: var(--accent-primary);"></i>
                                <span><?= htmlspecialchars($settings['contact_address']) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div>
                <form class="app-card" style="padding: 30px;" onsubmit="event.preventDefault(); alert('Thank you for reaching out! We will get back to you soon.'); this.reset();">
                    <div class="form-grid">
                        <div>
                            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Your Name</label>
                            <input type="text" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Your Email</label>
                            <input type="email" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Subject</label>
                        <input type="text" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Message</label>
                        <textarea rows="5" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem; width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
