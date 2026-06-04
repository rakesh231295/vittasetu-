<?php
$page_title = 'Vittasetu | Calculators';
include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="img/15.jpg" alt="Financial calculators and planning tools">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1>Calculators</h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <span>Calculators</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Page Intro</span>
                <h2>Make smarter financial decisions with our easy-to-use calculators</h2>
                <p>Use simple financial tools to estimate repayments, plan borrowing, and understand your commitments with greater clarity.</p>
            </div>

            <div class="grid-2 calculator-layout">
                <div class="card calculator-info-card">
                    <span class="eyebrow">EMI Calculator</span>
                    <h3>Calculate your monthly loan EMI instantly and plan your finances better.</h3>
                    <p class="mb-0">Enter your loan amount, interest rate, and repayment tenure to get a quick estimate of your monthly EMI.</p>
                </div>

                <div class="card calculator-form-card">
                    <form class="calculator-form" id="emiCalculator">
                        <input type="number" class="form-control" id="loanAmount" placeholder="Loan Amount" min="0" step="1000">
                        <input type="number" class="form-control" id="interestRate" placeholder="Interest Rate (%)" min="0" step="0.1">
                        <input type="number" class="form-control form-control-full" id="loanTenure" placeholder="Tenure (Months)" min="1" step="1">
                        <button type="button" class="btn btn-primary hero-form-submit" onclick="calculateEMI()">Calculate EMI</button>
                    </form>
                    <div class="calculator-result" id="emiResult">Your estimated EMI will appear here.</div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function calculateEMI() {
    const principal = parseFloat(document.getElementById('loanAmount').value) || 0;
    const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
    const months = parseFloat(document.getElementById('loanTenure').value) || 0;
    const result = document.getElementById('emiResult');

    if (!principal || !annualRate || !months) {
        result.textContent = 'Please enter loan amount, interest rate, and tenure.';
        return;
    }

    const monthlyRate = annualRate / 12 / 100;
    const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, months)) /
        (Math.pow(1 + monthlyRate, months) - 1);

    if (!isFinite(emi)) {
        result.textContent = 'Unable to calculate EMI. Please check the entered values.';
        return;
    }

    result.textContent = 'Estimated EMI: Rs. ' + emi.toFixed(2);
}
</script>

<?php include __DIR__ . '/footer.php'; ?>
