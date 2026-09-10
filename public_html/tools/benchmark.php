<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'Manufacturing Cost Benchmark Tool | GroEdge';
$page_description = 'Compare your manufacturing costs against Indian industry benchmarks. Identify savings opportunities across OEE, scrap, energy, labour, and maintenance.';
$current_page = 'resources';
include __DIR__ . '/../includes/header.php';
?>

<style>
.tool-container{max-width:800px;margin:0 auto;padding:20px}
.tool-banner{background:var(--ink);color:#fff;padding:40px 30px;border-radius:8px;margin-bottom:30px;text-align:center}
.tool-banner h1{font-size:1.8rem;margin:0 0 10px}
.tool-banner p{margin:0;opacity:.85;font-size:.95rem}
.tool-progress-wrap{position:sticky;top:0;z-index:10;background:var(--paper);padding:12px 0;border-bottom:1px solid var(--line);margin-bottom:25px}
.tool-progress{width:100%;height:8px;background:var(--line);border-radius:4px;overflow:hidden}
.tool-progress-fill{height:100%;background:var(--accent);border-radius:4px;transition:width .4s ease}
.tool-progress-label{text-align:center;font-size:.8rem;color:#666;margin-top:4px}
.tool-step{display:none}
.tool-step.active{display:block}
.tool-input-group{background:#fff;border:1px solid var(--line);border-left:4px solid var(--accent);border-radius:6px;padding:20px 24px;margin-bottom:16px}
.tool-input-group label{display:block;font-weight:600;color:var(--ink);margin-bottom:6px;font-size:.9rem}
.tool-input-group .hint{font-size:.78rem;color:#888;margin-bottom:8px}
.tool-input-group input{width:100%;padding:10px 14px;border:1px solid var(--line);border-radius:6px;font-size:1rem;box-sizing:border-box}
.tool-input-group input:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(139,197,63,.2)}
.tool-nav{display:flex;justify-content:space-between;margin-top:28px}
.tool-nav button{padding:12px 30px;border:none;border-radius:6px;font-size:.95rem;cursor:pointer;font-weight:600;transition:all .2s}
.tool-nav .btn-back{background:var(--line);color:var(--ink)}
.tool-nav .btn-back:hover{background:#bcc8d4}
.tool-nav .btn-next{background:var(--accent);color:var(--ink)}
.tool-nav .btn-next:hover{background:var(--accent-deep);color:#fff}
.tool-results{display:none;text-align:center}
.tool-results.active{display:block}
.tool-results h2{font-size:1.6rem;margin:0 0 8px;color:var(--ink)}
.tool-score-big{font-size:3rem;font-weight:700;margin:10px 0}
.tool-comparison{margin:25px 0;text-align:left}
.tool-comparison table{width:100%;border-collapse:collapse}
.tool-comparison th{text-align:left;padding:10px 12px;border-bottom:2px solid var(--ink);font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;color:var(--ink)}
.tool-comparison td{padding:10px 12px;border-bottom:1px solid var(--line);font-size:.9rem}
.tool-comparison .val{font-weight:700}
.tool-comparison .bench{color:#888;font-size:.8rem}
.tool-badge{display:inline-block;padding:3px 10px;border-radius:12px;font-size:.75rem;font-weight:600}
.badge-red{background:#fdeaea;color:#e74c3c}
.badge-yellow{background:#fef6e4;color:#e8a317}
.badge-green{background:#e8f8f0;color:#27ae60}
.savings-box{background:linear-gradient(135deg,var(--ink) 0%,var(--ink-mid) 70%);color:#fff;padding:30px;border-radius:8px;margin:25px 0}
.savings-box h3{margin:0 0 6px;color:var(--accent)}
.savings-box .amount{font-size:2.2rem;font-weight:700;color:var(--accent);margin:10px 0}
.savings-box p{margin:0;opacity:.8;font-size:.85rem}
.gauge-wrap{margin:20px 0}
.gauge-circle{width:160px;height:160px;border-radius:50%;margin:0 auto 10px;position:relative;background:conic-gradient(var(--accent) 0deg, var(--accent) 0deg, var(--line) 0deg, var(--line) 360deg);transition:background 1s ease}
.gauge-circle::after{content:'';position:absolute;top:20px;left:20px;right:20px;bottom:20px;background:#fff;border-radius:50%}
.gauge-label{position:absolute;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;z-index:1;font-size:1.6rem;font-weight:700;color:var(--ink)}
.gauge-title{font-size:.85rem;color:#666;margin-top:8px}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>Manufacturing Cost Benchmark Tool</h1>
    <p>Input your operational data and instantly see how you compare against Indian manufacturing benchmarks — with estimated savings potential.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Step 1 of 2</div>
  </div>

  <form id="benchForm">
    <div class="tool-step active" id="step1">
      <div class="tool-input-group">
        <label for="output">Monthly Production Output (units)</label>
        <div class="hint">Total units produced per month across all lines</div>
        <input type="number" id="output" min="1" placeholder="e.g. 50000" required>
      </div>
      <div class="tool-input-group">
        <label for="employees">Total Employees (Production & Support)</label>
        <div class="hint">Headcount including direct and indirect labour</div>
        <input type="number" id="employees" min="1" placeholder="e.g. 200" required>
      </div>
      <div class="tool-input-group">
        <label for="scrap">Scrap Rate (%)</label>
        <div class="hint">Percentage of production rejected or scrapped</div>
        <input type="number" id="scrap" min="0" max="100" step="0.1" placeholder="e.g. 5.2" required>
      </div>
      <div class="tool-input-group">
        <label for="oee">OEE (%)</label>
        <div class="hint">Overall Equipment Effectiveness</div>
        <input type="number" id="oee" min="0" max="100" step="0.1" placeholder="e.g. 58" required>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-input-group">
        <label for="energy">Energy Cost per Unit (₹)</label>
        <div class="hint">Electricity + fuel cost divided by units produced</div>
        <input type="number" id="energy" min="0" step="0.1" placeholder="e.g. 15" required>
      </div>
      <div class="tool-input-group">
        <label for="labour">Labour Cost per Unit (₹)</label>
        <div class="hint">Total wages + benefits divided by units produced</div>
        <input type="number" id="labour" min="0" step="0.1" placeholder="e.g. 50" required>
      </div>
      <div class="tool-input-group">
        <label for="maint">Maintenance Cost (% of Asset Value)</label>
        <div class="hint">Annual maintenance spend as percentage of total asset value</div>
        <input type="number" id="maint" min="0" max="100" step="0.1" placeholder="e.g. 4" required>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your Benchmark Report</h2>
    <div class="gauge-wrap">
      <div class="gauge-circle" id="gauge">
        <div class="gauge-label" id="gaugeLabel">0%</div>
      </div>
      <div class="gauge-title">Your Operational Cost Score</div>
    </div>

    <div class="tool-comparison">
      <table>
        <thead><tr><th>Metric</th><th>Your Value</th><th>Indian Benchmark</th><th>Status</th></tr></thead>
        <tbody id="compBody"></tbody>
      </table>
    </div>

    <div class="savings-box" id="savingsBox">
      <h3>Estimated Annual Savings Opportunity</h3>
      <div class="amount" id="savingsAmount"></div>
      <p id="savingsNote"></p>
    </div>

    <div class="cta-box">
      <h3>Turn benchmarks into results</h3>
      <p>Our cost reduction programmes typically deliver 15-25% savings within 6 months. Let's build your roadmap.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  let step = 0;
  const benchmarks = {
    oee:{bench:65,wc:85,name:'OEE',unit:'%',higher:true},
    scrap:{bench:3,wc:1,name:'Scrap Rate',unit:'%',higher:false},
    energy:{bench:12,wc:8,name:'Energy Cost',unit:'₹/unit',higher:false},
    labour:{bench:45,wc:30,name:'Labour Cost',unit:'₹/unit',higher:false},
    maint:{bench:3,wc:1.5,name:'Maintenance Cost',unit:'% of assets',higher:false}
  };

  function showStep(i){
    document.querySelectorAll('.tool-step').forEach((s,idx)=>{s.classList.toggle('active',idx===i)});
    document.getElementById('btnBack').style.display=i===0?'none':'inline-block';
    document.getElementById('btnNext').textContent=i===1?'Calculate':'Next';
    document.getElementById('progressFill').style.width=((i+1)/2*100)+'%';
    document.getElementById('progressLabel').textContent='Step '+(i+1)+' of 2';
  }

  window.nextStep = function(){
    if(step===0){
      const ids=['output','employees','scrap','oee'];
      for(const id of ids){
        const el=document.getElementById(id);
        if(!el.value){el.style.boxShadow='0 0 0 2px #e74c3c';setTimeout(()=>el.style.boxShadow='',1500);return;}
      }
      step=1;showStep(1);
    } else {
      const ids=['energy','labour','maint'];
      for(const id of ids){
        const el=document.getElementById(id);
        if(!el.value){el.style.boxShadow='0 0 0 2px #e74c3c';setTimeout(()=>el.style.boxShadow='',1500);return;}
      }
      showResults();
    }
  };

  window.prevStep = function(){if(step>0){step--;showStep(step);}};

  function getStatus(val,bench,higher){
    const ratio = val/bench;
    if(higher){
      if(val>=bench) return {text:'At/Above Benchmark',cls:'badge-green'};
      if(ratio>=0.85) return {text:'Close to Benchmark',cls:'badge-yellow'};
      return {text:'Below Benchmark',cls:'badge-red'};
    } else {
      if(val<=bench) return {text:'At/Below Benchmark',cls:'badge-green'};
      if(val<=bench*1.2) return {text:'Close to Benchmark',cls:'badge-yellow'};
      return {text:'Above Benchmark',cls:'badge-red'};
    }
  }

  function showResults(){
    document.getElementById('benchForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    const oee=parseFloat(document.getElementById('oee').value);
    const scrap=parseFloat(document.getElementById('scrap').value);
    const energy=parseFloat(document.getElementById('energy').value);
    const labour=parseFloat(document.getElementById('labour').value);
    const maint=parseFloat(document.getElementById('maint').value);
    const output=parseFloat(document.getElementById('output').value);

    let score=0;let max=0;
    const rows=[];
    const metrics=[
      {key:'oee',val:oee},{key:'scrap',val:scrap},{key:'energy',val:energy},{key:'labour',val:labour},{key:'maint',val:maint}
    ];
    metrics.forEach(m=>{
      const b=benchmarks[m.key];
      const s=getStatus(m.val,b.bench,b.higher);
      rows.push('<tr><td>'+b.name+'</td><td class="val">'+m.val+' '+b.unit+'</td><td class="bench">'+b.bench+' '+b.unit+' (WC: '+b.wc+')</td><td><span class="tool-badge '+s.cls+'">'+s.text+'</span></td></tr>');
      if(b.higher){
        score+=Math.min(m.val/b.bench,1.3);
      } else {
        score+=Math.min(b.bench/Math.max(m.val,0.1),1.3);
      }
      max+=1.3;
    });
    document.getElementById('compBody').innerHTML=rows.join('');

    const pct=Math.round((score/max)*100);
    const deg=Math.round(pct*3.6);
    const gaugeEl=document.getElementById('gauge');
    const color=pct>=75?'#27ae60':pct>=50?'#e8a317':'#e74c3c';
    gaugeEl.style.background='conic-gradient('+color+' 0deg, '+color+' '+deg+'deg, #d0dae4 '+deg+'deg, #d0dae4 360deg)';
    document.getElementById('gaugeLabel').textContent=pct+'%';

    const annualOutput=output*12;
    const energySaving=Math.max(0,(energy-8))*annualOutput;
    const labourSaving=Math.max(0,(labour-45))*annualOutput;
    const scrapSaving=Math.max(0,(scrap-3)/100*annualOutput*labour);
    const maintPct=Math.max(0,maint-3);
    const totalSaving=Math.round(energySaving+labourSaving+scrapSaving);
    document.getElementById('savingsAmount').textContent='₹'+totalSaving.toLocaleString('en-IN');
    document.getElementById('savingsNote').textContent='Based on energy, labour, and scrap improvements alone. Potential is higher when OEE gains and throughput increases are factored in.';

    document.getElementById('results').scrollIntoView({behavior:'smooth'});
  }

  showStep(0);
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
