<?php
$page_title = 'Vittasetu | Need Loans';
include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page service-detail-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="img/Loans-breadcrumb.png" alt="Need Loans">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1>Need Loans</h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <span>Need Loans</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<style>
.loan-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}
.loan-card {
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}
.loan-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,86,179,0.1);
    border-color: #0056b3;
}
.loan-card-icon {
    width: 70px;
    height: 70px;
    background: #f4f7f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #0056b3;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}
.loan-card:hover .loan-card-icon {
    background: #0056b3;
    color: #fff;
}
.loan-card h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1a2a40;
    margin-bottom: 15px;
}
.loan-card p {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 25px;
    line-height: 1.6;
}
.loan-card-btn {
    margin-top: auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    color: #0056b3;
    font-size: 0.9rem;
    text-transform: uppercase;
    transition: gap 0.3s ease;
}
.loan-card:hover .loan-card-btn {
    gap: 12px;
}
.loan-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 50px;
}
</style>

    <section class="section">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Smart Loan Solutions</span>
                <h2>Explore Our Loan Solutions</h2>
                <p>We provide a variety of loan options tailored to your personal and business financial needs with quick processing and minimal documentation.</p>
            </div>
            
            <div class="loan-grid">
                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Working%20Capital%20Finance." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-coins"></i></div>
                        <h3>Working Capital Finance</h3>
                        <p>Manage day-to-day operations seamlessly with our fund and non-fund based working capital solutions.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>
                
                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20a%20Home%20Loan." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-house"></i></div>
                        <h3>Home Loans</h3>
                        <p>Make your dream home a reality with easy, affordable, and flexible home loans designed for you.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>
                
                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20a%20Loan%20Against%20Property." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-building"></i></div>
                        <h3>Loan Against Property</h3>
                        <p>Unlock the hidden value of your real estate property to meet large business or personal financial requirements.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Term%20Loans." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        <h3>Term Loans</h3>
                        <p>Secure long-term funding for capital expenditure, business expansion, or strategic acquisitions.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Project%20Finance." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-helmet-safety"></i></div>
                        <h3>Project Finance</h3>
                        <p>Comprehensive funding and advisory for large-scale infrastructure and industrial projects.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Solar%20Finance." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-solar-panel"></i></div>
                        <h3>Solar Finance</h3>
                        <p>Transition to green energy with specially designed funding for solar power installations and infrastructure.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Supply%20Chain%20Finance." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-dolly"></i></div>
                        <h3>Supply Chain Finance</h3>
                        <p>Optimize working capital and improve vendor relationships with smart supply chain funding solutions.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Business%20Instalment%20Loans." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-briefcase"></i></div>
                        <h3>Business Instalment Loans</h3>
                        <p>Unsecured business loans with easy EMIs to meet immediate business cash flow requirements.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>
                
                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20a%20Personal%20Loan." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-user"></i></div>
                        <h3>Personal Loans</h3>
                        <p>Meet your personal financial needs quickly, whether for medical emergencies, travel, or weddings.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20a%20Professional%20Loan." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-user-tie"></i></div>
                        <h3>Professional Loans</h3>
                        <p>Specialized credit facilities designed for doctors, CAs, architects, and other registered professionals.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Commercial%20Property%20Loans." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-city"></i></div>
                        <h3>Commercial Property &amp; Construction</h3>
                        <p>Dedicated loans for purchasing commercial spaces or financing large-scale construction projects.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>

                <a href="https://wa.me/919831040460?text=Hi%20Vittasetu,%20I%20am%20interested%20in%20Debt%20Consolidation." target="_blank" class="loan-card-link">
                    <div class="loan-card">
                        <div class="loan-card-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        <h3>Debt Consolidation</h3>
                        <p>Simplify your finances by combining multiple high-interest debts into one easily manageable lower-interest loan.</p>
                        <span class="loan-card-btn">Apply on WhatsApp <i class="fa-brands fa-whatsapp"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
