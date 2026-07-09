<?php
$page_title = 'Vittasetu | Financial Health Report';
include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page service-detail-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="img/Health-breadcrumb.png" alt="Financial health report and analysis">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1>Financial Health Report</h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <a href="products.php">Services</a>
                            <span>&gt;</span>
                            <span>Financial Health Report</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section service-overview-section">
        <div class="container">
            <div class="service-detail-hero">
                <div class="service-detail-copy">
                    <span class="eyebrow">Overview</span>
                    <h2>Detailed financial analysis with expert recommendations for growth</h2>
                    <p>Get a detailed analysis of your financial position with expert recommendations for improvement and growth. Our Financial Health Report provides valuable insights into your financial performance.</p>
                    <div class="btn-row service-detail-actions">
                        <a href="contact.php" class="btn btn-primary">Request Report</a>
                        <a href="products.php" class="btn btn-secondary">View All Services</a>
                    </div>
                </div>
                <div class="media-frame service-detail-media">
                    <img src="img/analysis.png" alt="Financial dashboard and performance report review">
                </div>
            </div>
        </div>
    </section>

<style>
.health-summary-section {
    background: #f4f7f9;
    padding: 80px 0;
    text-align: center;
}
.health-summary-section h2 {
    color: #1a2a40;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
}
.health-summary-section > p {
    color: #555;
    font-size: 1.1rem;
    margin-bottom: 50px;
}
.health-dashboard-wrapper {
    position: relative;
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 300px 1fr;
    gap: 30px;
    align-items: center;
}
@media (max-width: 991px) {
    .health-dashboard-wrapper {
        grid-template-columns: 1fr;
    }
    .health-center-image {
        display: none;
    }
}
.health-cards-column {
    display: flex;
    flex-direction: column;
    gap: 25px;
}
.health-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    text-align: left;
    border: 2px solid transparent;
}
.health-card.border-green { border-color: #28a745; }
.health-card.border-red { border-color: #dc3545; }
.health-card.border-orange { border-color: #fd7e14; }
.health-card.border-blue { border-color: #0056b3; }

.health-card-header {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 15px;
}
.health-card-icon {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #333;
}
.health-card-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #1a2a40;
    margin: 0 0 5px 0;
    text-transform: uppercase;
    line-height: 1.2;
}
.health-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    color: #fff;
}
.health-badge.badge-green { background: #28a745; }
.health-badge.badge-red { background: #dc3545; }
.health-badge.badge-orange { background: #fd7e14; }
.health-badge.badge-blue { background: #0056b3; }

.health-card p {
    font-size: 0.85rem;
    color: #555;
    margin-bottom: 15px;
    line-height: 1.5;
}
.health-card-link {
    font-size: 0.85rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.health-card-link.link-green { color: #28a745; }
.health-card-link.link-red { color: #dc3545; }
.health-card-link.link-orange { color: #fd7e14; }

.health-footer-summary {
    background: #fff;
    max-width: 900px;
    margin: 50px auto 0;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.health-footer-summary h3 {
    text-align: center;
    font-size: 1.1rem;
    color: #1a2a40;
    margin-bottom: 30px;
    position: relative;
    font-weight: 700;
}
.health-footer-summary h3::before, .health-footer-summary h3::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 32%;
    height: 1px;
    background: #e0e0e0;
}
.health-footer-summary h3::before { left: 0; }
.health-footer-summary h3::after { right: 0; }

.health-footer-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    text-align: center;
}
@media (max-width: 768px) {
    .health-footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
}
.health-footer-item i {
    font-size: 2rem;
    margin-bottom: 15px;
}
.health-footer-item h4 {
    font-size: 0.9rem;
    font-weight: 800;
    margin-bottom: 5px;
    color: #1a2a40;
}
.health-footer-item p {
    font-size: 0.8rem;
    color: #666;
    margin: 0;
}
</style>

<section class="section health-summary-section">
    <div class="container">
        <h2>Health Summary & Synopsis</h2>
        <p>A 360° view of your financial health, risk posture and compliance status<br>to drive informed decisions and sustainable growth.</p>
        
        <div class="health-dashboard-wrapper">
            <!-- Left Column -->
            <div class="health-cards-column">
                <div class="health-card border-green">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-file-contract"></i></div>
                        <div>
                            <h3 class="health-card-title">Bureau Check</h3>
                            <span class="health-badge badge-green"><i class="fa-solid fa-check"></i> GOOD</span>
                        </div>
                    </div>
                    <p>Healthy performance, but regular monitoring is required to sustain results.</p>
                    <a href="#" class="health-card-link link-green">Keep the Good Work <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                
                <div class="health-card border-red">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-piggy-bank" style="color:#dc3545;"></i></div>
                        <div>
                            <h3 class="health-card-title">Emergency &<br>Sinking Fund Provision</h3>
                            <span class="health-badge badge-red"><i class="fa-solid fa-circle-exclamation"></i> BAD</span>
                        </div>
                    </div>
                    <p>Please consult financial experts immediately to address critical issues.</p>
                    <a href="#" class="health-card-link link-red">Watchout <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="health-card border-green">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-file-shield"></i></div>
                        <div>
                            <h3 class="health-card-title">Regulatory<br>Compliances</h3>
                            <span class="health-badge badge-green"><i class="fa-solid fa-check-double"></i> FULLY COMPLIANT</span>
                        </div>
                    </div>
                    <p>Outstanding compliance and governance, keep maintaining this discipline.</p>
                    <a href="#" class="health-card-link link-green">Keep the Good Work <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Center Image -->
            <div class="health-center-image">
                <!-- Using placeholder image to represent the central figure from mockup -->
                <img src="img/14.jpg" alt="Financial Advisor" style="border-radius: 20px; object-fit: cover; height: 500px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            </div>

            <!-- Right Column -->
            <div class="health-cards-column">
                <div class="health-card border-blue">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-scale-balanced" style="color:#0056b3;"></i></div>
                        <div>
                            <h3 class="health-card-title">Financial Position</h3>
                            <span class="health-badge badge-green"><i class="fa-solid fa-check"></i> GOOD</span>
                        </div>
                    </div>
                    <p>Healthy performance, but regular monitoring is required to sustain results.</p>
                    <a href="#" class="health-card-link link-green">Keep the Good Work <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="health-card border-orange">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-gauge-high"></i></div>
                        <div>
                            <h3 class="health-card-title">Key Performance<br>Indicator</h3>
                            <span class="health-badge badge-orange"><i class="fa-solid fa-minus"></i> AVERAGE</span>
                        </div>
                    </div>
                    <p>Performance is acceptable but needs improvement; strengthen key areas.</p>
                    <a href="#" class="health-card-link link-orange">Take Corrective Actions <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="health-card border-blue">
                    <div class="health-card-header">
                        <div class="health-card-icon"><i class="fa-solid fa-shield-halved" style="color:#0056b3;"></i></div>
                        <div>
                            <h3 class="health-card-title">Credit Exposure<br>Risk</h3>
                            <span class="health-badge badge-green"><i class="fa-solid fa-check"></i> GOOD</span>
                        </div>
                    </div>
                    <p>Healthy performance, but regular monitoring is required to sustain results.</p>
                    <a href="#" class="health-card-link link-green">Keep the Good Work <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="health-footer-summary">
            <h3>What This Means for You?</h3>
            <div class="health-footer-grid">
                <div class="health-footer-item">
                    <i class="fa-solid fa-desktop" style="color:#0056b3;"></i>
                    <h4>Continuous Monitoring</h4>
                    <p>Track metrics regularly</p>
                </div>
                <div class="health-footer-item">
                    <i class="fa-solid fa-shield-cat" style="color:#28a745;"></i>
                    <h4>Risk Mitigation</h4>
                    <p>Strengthen weak areas</p>
                </div>
                <div class="health-footer-item">
                    <i class="fa-solid fa-arrow-trend-up" style="color:#fd7e14;"></i>
                    <h4>Better Decisions</h4>
                    <p>Data-driven insights</p>
                </div>
                <div class="health-footer-item">
                    <i class="fa-solid fa-users-gear" style="color:#0056b3;"></i>
                    <h4>Sustainable Growth</h4>
                    <p>Build long-term value</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="section service-benefits-section">
        <div class="container">
            <div class="service-split-layout">
                <div>
                    <span class="eyebrow">Benefits</span>
                    <h2>Actionable financial clarity for better decisions and planning</h2>
                    <p>Our report helps you understand your current financial position, identify risks and opportunities, and make informed choices for improvement.</p>
                </div>
                <div class="card service-check-card">
                    <ul class="service-check-list">
                        <li><i class="fa-solid fa-check"></i> Financial performance review</li>
                        <li><i class="fa-solid fa-check"></i> Identify risks &amp; opportunities</li>
                        <li><i class="fa-solid fa-check"></i> Actionable insights</li>
                        <li><i class="fa-solid fa-check"></i> Better decision-making</li>
                        <li><i class="fa-solid fa-check"></i> Improved financial planning</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Ideal For</span>
                <h2>Financial analysis for owners, businesses, startups, and individuals</h2>
            </div>

            <div class="service-audience-grid">
                <div class="card service-audience-card">
                    <i class="fa-solid fa-user-tie"></i>
                    <h3>Business Owners</h3>
                </div>
                <div class="card service-audience-card">
                    <i class="fa-solid fa-store"></i>
                    <h3>SMEs</h3>
                </div>
                <div class="card service-audience-card">
                    <i class="fa-solid fa-rocket"></i>
                    <h3>Startups</h3>
                </div>
                <div class="card service-audience-card">
                    <i class="fa-solid fa-compass"></i>
                    <h3>Individuals Seeking Financial Analysis</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="section process-section-home">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Our Process</span>
                <h2>A clear reporting process from data collection to final recommendations</h2>
            </div>

            <div class="service-process-grid">
                <div class="card service-process-card">
                    <span>01</span>
                    <h3>Data Collection</h3>
                </div>
                <div class="card service-process-card">
                    <span>02</span>
                    <h3>Financial Analysis</h3>
                </div>
                <div class="card service-process-card">
                    <span>03</span>
                    <h3>Report Preparation</h3>
                </div>
                <div class="card service-process-card">
                    <span>04</span>
                    <h3>Expert Review</h3>
                </div>
                <div class="card service-process-card">
                    <span>05</span>
                    <h3>Final Recommendations</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card cta-panel cta-panel-home service-detail-cta">
                <div class="grid-2 cta-layout cta-layout-centered">
                    <div class="cta-copy">
                        <span class="eyebrow">Why Choose Vittasetu</span>
                        <h2>Easy-to-understand reports backed by expert financial analysis</h2>
                        <p>We deliver clear, easy-to-understand financial reports backed by expert analysis and actionable recommendations.</p>
                        <div class="hero-actions cta-actions">
                            <a href="contact.php" class="btn btn-primary">Request Report</a>
                        </div>
                    </div>
                    <div class="media-frame cta-main-media product-cta-media">
                        <img src="img/expert-2.png" alt="Expert financial report review and recommendations">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
