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
                    <div class="calculator-result" id="emiResult">
                        <p style="text-align: center; color: #666; margin: 0;">Enter loan details to view the EMI breakdown.</p>
                    </div>
                </div>
            </div>
            
            <div id="amortizationContainer" style="display: none; margin-top: 40px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 12px; border: 1px solid #eaeaea;"></div>
        </div>
    </section>
</main>

<script>
function calculateEMI() {
    const principal = parseFloat(document.getElementById('loanAmount').value) || 0;
    const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
    const months = parseFloat(document.getElementById('loanTenure').value) || 0;
    const result = document.getElementById('emiResult');
    const tableContainer = document.getElementById('amortizationContainer');

    if (!principal || !annualRate || !months) {
        result.innerHTML = '<p style="text-align: center; color: #e74c3c; margin: 0;">Please enter loan amount, interest rate, and tenure.</p>';
        if (tableContainer) tableContainer.style.display = 'none';
        return;
    }

    const monthlyRate = annualRate / 12 / 100;
    const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, months)) /
        (Math.pow(1 + monthlyRate, months) - 1);

    if (!isFinite(emi)) {
        result.innerHTML = '<p style="text-align: center; color: #e74c3c; margin: 0;">Unable to calculate EMI. Please check the entered values.</p>';
        if (tableContainer) tableContainer.style.display = 'none';
        return;
    }

    const totalAmount = emi * months;
    const totalInterest = totalAmount - principal;

    const formatCurrency = (amount) => '₹ ' + Math.round(amount).toLocaleString('en-IN');

    result.innerHTML = `
        <div class="emi-breakdown" style="text-align:left; padding-top: 10px;">
            <h4 style="margin-bottom: 20px; text-align: center;">Calculation Breakdown</h4>
            
            <div style="display:flex; justify-content:space-between; margin-bottom: 12px; align-items: center;">
                <span style="color: #666;">Monthly EMI</span>
                <strong style="color: var(--primary, #0056b3); font-size: 1.25em;">${formatCurrency(emi)}</strong>
            </div>
            
            <div style="display:flex; justify-content:space-between; margin-bottom: 12px;">
                <span style="color: #666;">Principal Amount</span>
                <strong>${formatCurrency(principal)}</strong>
            </div>
            
            <div style="display:flex; justify-content:space-between; margin-bottom: 12px;">
                <span style="color: #666;">Total Interest Payable</span>
                <strong>${formatCurrency(totalInterest)}</strong>
            </div>
            
            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #ddd;">
            
            <div style="display:flex; justify-content:space-between; font-weight: bold; font-size: 1.1em;">
                <span>Total Payment (Principal + Interest)</span>
                <strong>${formatCurrency(totalAmount)}</strong>
            </div>
        </div>
    `;

    // Generate Amortization Schedule
    let scheduleHTML = `
        <table style="width: 100%; border-collapse: collapse; text-align: center; background: #fff; font-size: 0.95rem;">
            <thead>
                <tr style="background-color: #f4f6f8; color: #2c3e50; font-weight: 700;">
                    <th style="padding: 16px; border: 1px solid #eaeaea;">NO</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">DATE</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">OPENING</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">EMI</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">OUTSTANDING</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">INTEREST</th>
                    <th style="padding: 16px; border: 1px solid #eaeaea;">PRINCIPAL</th>
                </tr>
            </thead>
            <tbody>
    `;

    let currentBalance = principal;
    const today = new Date();
    let currentMonth = today.getMonth(); // 0-11
    let currentYear = today.getFullYear();

    for (let i = 1; i <= months; i++) {
        currentMonth++;
        if(currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        let displayMonth = currentMonth + 1;
        let dateStr = String(displayMonth).padStart(2, '0') + '/' + currentYear;
        
        let interestForMonth = currentBalance * monthlyRate;
        let principalForMonth = emi - interestForMonth;
        let opening = currentBalance;
        currentBalance = currentBalance - principalForMonth;
        if (currentBalance < 0) currentBalance = 0; // handle slight floating point errors

        scheduleHTML += `
            <tr style="color: #555; transition: background 0.3s ease;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                <td style="padding: 14px; border: 1px solid #eaeaea;">${i}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${dateStr}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${formatCurrency(opening)}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${formatCurrency(emi)}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${formatCurrency(currentBalance)}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${formatCurrency(interestForMonth)}</td>
                <td style="padding: 14px; border: 1px solid #eaeaea;">${formatCurrency(principalForMonth)}</td>
            </tr>
        `;
    }

    scheduleHTML += `</tbody></table>`;
    if (tableContainer) {
        tableContainer.innerHTML = scheduleHTML;
        tableContainer.style.display = 'block';
    }
}
</script>

<?php include __DIR__ . '/footer.php'; ?>
