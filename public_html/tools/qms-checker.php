<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'QMS Audit Preparation Checker | GroEdge';
$page_description = 'Check your ISO 9001 / IATF 16949 readiness across 6 categories. Identify gaps before your next audit.';
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
.tool-cat-title{font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:12px;padding-bottom:8px;border-bottom:2px solid var(--accent)}
.tool-checklist{display:flex;flex-direction:column;gap:8px}
.tool-check-item{display:flex;align-items:center;cursor:pointer;padding:10px 14px;border:1px solid var(--line);border-radius:6px;transition:all .2s;font-size:.88rem}
.tool-check-item:hover{border-color:var(--accent);background:#f8fdf2}
.tool-check-item input{margin-right:10px;accent-color:var(--accent-deep);width:18px;height:18px}
.tool-check-item input:checked + span{font-weight:600;color:var(--accent-deep)}
.tool-check-item:has(input:checked){border-color:var(--accent-deep);background:#f0f9e4}
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
.tool-classification{display:inline-block;padding:8px 20px;border-radius:20px;font-weight:600;font-size:.95rem;margin-bottom:25px}
.tool-cat-bars{text-align:left;margin:25px 0}
.tool-cat-bar{margin-bottom:16px}
.tool-cat-bar .label-row{display:flex;justify-content:space-between;margin-bottom:4px;font-size:.85rem}
.tool-cat-bar .label-row .cat-name{font-weight:600;color:var(--ink)}
.tool-cat-bar .label-row .cat-pct{font-weight:700}
.tool-cat-bar .bar-track{width:100%;height:14px;background:var(--line);border-radius:7px;overflow:hidden}
.tool-cat-bar .bar-fill{height:100%;border-radius:7px;transition:width 1s ease;width:0}
.tool-cat-bar .missing{font-size:.78rem;color:#e74c3c;margin-top:4px;font-style:italic}
.tool-tips{background:#fff;border:1px solid var(--line);border-radius:8px;padding:20px;margin:20px 0;text-align:left}
.tool-tips h3{margin:0 0 12px;font-size:1rem;color:var(--ink)}
.tool-tips ul{margin:0;padding-left:20px}
.tool-tips li{margin-bottom:8px;font-size:.88rem;color:var(--ink)}
.tool-tips li strong{color:var(--accent-deep)}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>QMS Audit Preparation Checker</h1>
    <p>Check your quality management system readiness across 6 categories. Identify what's missing before your next certification or surveillance audit.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Step 1 of 3</div>
  </div>

  <form id="qmsForm">
    <div class="tool-step active" id="step1">
      <div class="tool-cat-title">1. Documentation</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms1" value="doc1"><span>Quality manual exists and is current</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms1" value="doc2"><span>Documented procedures for all key processes</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms1" value="doc3"><span>Work instructions at point of use</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms1" value="doc4"><span>Quality records maintained and retrievable</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms1" value="doc5"><span>Document revision control system in place</span></label>
      </div>

      <div class="tool-cat-title" style="margin-top:24px">2. Process Control</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms2" value="pc1"><span>Process flow diagrams for all product lines</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms2" value="pc2"><span>Control plans developed and reviewed</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms2" value="pc3"><span>PFMEA completed and updated regularly</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms2" value="pc4"><span>MSA / Gage R&R conducted for critical measurements</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms2" value="pc5"><span>SPC applied to critical-to-quality characteristics</span></label>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-cat-title">3. Internal Audits</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms3" value="ia1"><span>Annual audit schedule defined and followed</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms3" value="ia2"><span>Auditors trained and qualified (internal or IRCA)</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms3" value="ia3"><span>NCR tracking system with closure verification</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms3" value="ia4"><span>Management review conducted per schedule</span></label>
      </div>

      <div class="tool-cat-title" style="margin-top:24px">4. Corrective Action</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms4" value="ca1"><span>8D or equivalent corrective action process defined</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms4" value="ca2"><span>Root cause analysis methodology standardised</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms4" value="ca3"><span>Effectiveness verification conducted after closure</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms4" value="ca4"><span>Lessons learned shared across the organisation</span></label>
      </div>
    </div>

    <div class="tool-step" id="step3">
      <div class="tool-cat-title">5. Supplier Quality</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms5" value="sq1"><span>Approved supplier list maintained and current</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms5" value="sq2"><span>Incoming inspection procedures defined</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms5" value="sq3"><span>Supplier audit programme in place</span></label>
      </div>

      <div class="tool-cat-title" style="margin-top:24px">6. Customer Focus</div>
      <div class="tool-checklist">
        <label class="tool-check-item"><input type="checkbox" name="qms6" value="cf1"><span>Customer requirements documented and accessible</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms6" value="cf2"><span>Complaint handling process with CAR tracking</span></label>
        <label class="tool-check-item"><input type="checkbox" name="qms6" value="cf3"><span>OTIF performance tracked and reported</span></label>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your QMS Readiness Report</h2>
    <div class="tool-score-big" id="overallScore"></div>
    <div class="tool-classification" id="classification"></div>

    <div class="tool-cat-bars" id="catBars"></div>

    <div class="tool-tips" id="tipsBox">
      <h3>What's Missing — Action Items</h3>
      <ul id="tipsList"></ul>
    </div>

    <div class="cta-box">
      <h3>Need help closing the gaps before audit day?</h3>
      <p>Our QMS readiness programme gets you audit-ready in 6-8 weeks with hands-on support for documentation, process controls, and internal audits.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  const cats=[
    {name:'Documentation',key:'qms1',total:5,tips:['Draft or update your quality manual','Create procedure documents for each process','Develop visual work instructions','Set up a records management system','Implement revision control for all documents']},
    {name:'Process Control',key:'qms2',total:5,tips:['Map all process flows with swimlane diagrams','Develop control plans for each product/process','Conduct PFMEA workshops with cross-functional teams','Run MSA/Gage R&R for all critical gauges','Implement SPC charts on CTQ characteristics']},
    {name:'Internal Audits',key:'qms3',total:4,tips:['Build an annual audit calendar covering all processes','Train auditors to ISO 19011 or IRCA standard','Set up an NCR tracker with root cause and closure logic','Schedule management reviews quarterly at minimum']},
    {name:'Corrective Action',key:'qms4',total:4,tips:['Formalise your 8D or equivalent CAR process','Standardise root cause tools (5-Why, Ishikawa, FTA)','Require effectiveness checks before NCR closure','Create a lessons-learned repository and review cadence']},
    {name:'Supplier Quality',key:'qms5',total:3,tips:['Audit and qualify all active suppliers','Define incoming inspection criteria per material type','Schedule periodic supplier audits for critical sources']},
    {name:'Customer Focus',key:'qms6',total:3,tips:['Maintain a living register of customer-specific requirements','Implement a complaint-to-CAR closed-loop system','Track OTIF and share results in management review']}
  ];
  let step=0;
  const totalSteps=3;
  const stepCats=[[0,1],[2,3],[4,5]];

  function showStep(i){
    document.querySelectorAll('.tool-step').forEach((s,idx)=>{s.classList.toggle('active',idx===i)});
    document.getElementById('btnBack').style.display=i===0?'none':'inline-block';
    document.getElementById('btnNext').textContent=i===totalSteps-1?'View Results':'Next';
    document.getElementById('progressFill').style.width=((i+1)/totalSteps*100)+'%';
    document.getElementById('progressLabel').textContent='Step '+(i+1)+' of '+totalSteps;
  }

  function stepValid(i){
    const catsIdxs=stepCats[i];
    for(const ci of catsIdxs){
      const checked=document.querySelectorAll('input[name="'+cats[ci].key+'"]:checked').length;
      if(checked===0){
        const el=document.querySelector('input[name="'+cats[ci].key+'"]').closest('.tool-cat-title');
        if(el){el.style.boxShadow='0 0 0 2px #e74c3c';setTimeout(()=>el.style.boxShadow='',1500);}
        return false;
      }
    }
    return true;
  }

  window.nextStep=function(){
    if(!stepValid(step)) return;
    if(step<totalSteps-1){step++;showStep(step);}
    else showResults();
  };

  window.prevStep=function(){if(step>0){step--;showStep(step);}};

  function getLevel(pct){
    if(pct<50) return {label:'Significant Gaps',color:'#e74c3c',bg:'#fdeaea'};
    if(pct<75) return {label:'Partially Ready',color:'#e8a317',bg:'#fef6e4'};
    if(pct<90) return {label:'Nearly Audit-Ready',color:'#27ae60',bg:'#e8f8f0'};
    return {label:'Audit-Ready',color:'#8bc53f',bg:'#f0f9e4'};
  }

  function showResults(){
    document.getElementById('qmsForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    let totalChecked=0;
    let totalItems=0;
    const catResults=[];

    cats.forEach(c=>{
      const checked=document.querySelectorAll('input[name="'+c.key+'"]:checked').length;
      const pct=Math.round((checked/c.total)*100);
      const missing=c.total-checked;
      catResults.push({name:c.name,checked:checked,total:c.total,pct:pct,missing:missing,tips:c.tips});
      totalChecked+=checked;
      totalItems+=c.total;
    });

    const overallPct=Math.round((totalChecked/totalItems)*100);
    const overallLevel=getLevel(overallPct);

    document.getElementById('overallScore').textContent=overallPct+'%';
    document.getElementById('overallScore').style.color=overallLevel.color;
    const cls=document.getElementById('classification');
    cls.textContent=overallLevel.label;
    cls.style.background=overallLevel.bg;
    cls.style.color=overallLevel.color;

    let barsHtml='';
    catResults.forEach(c=>{
      const color=c.pct>=90?'#8bc53f':c.pct>=75?'#27ae60':c.pct>=50?'#e8a317':'#e74c3c';
      const missingText=c.missing>0?'Missing: '+c.missing+' of '+c.total+' items':'All items checked';
      barsHtml+='<div class="tool-cat-bar">'+
        '<div class="label-row"><span class="cat-name">'+c.name+'</span><span class="cat-pct" style="color:'+color+'">'+c.checked+'/'+c.total+' ('+c.pct+'%)</span></div>'+
        '<div class="bar-track"><div class="bar-fill" data-width="'+c.pct+'" style="background:'+color+'"></div></div>'+
        (c.missing>0?'<div class="missing">'+missingText+'</div>':'')+'</div>';
    });
    document.getElementById('catBars').innerHTML=barsHtml;

    let tipsHtml='';
    catResults.filter(c=>c.missing>0).forEach(c=>{
      tipsHtml+='<li><strong>'+c.name+':</strong> '+c.tips.join('; ')+'</li>';
    });
    if(!tipsHtml) tipsHtml='<li>All items checked across all categories. You are well prepared for your audit.</li>';
    document.getElementById('tipsList').innerHTML=tipsHtml;

    setTimeout(()=>{
      document.querySelectorAll('.bar-fill').forEach(b=>{b.style.width=b.dataset.width+'%';});
    },100);

    document.getElementById('results').scrollIntoView({behavior:'smooth'});
  }

  showStep(0);

  document.querySelectorAll('.tool-check-item').forEach(lbl=>{
    lbl.addEventListener('click',function(e){
      if(e.target.tagName!=='INPUT'){
        const inp=this.querySelector('input');
        if(inp) inp.checked=!inp.checked;
        inp.dispatchEvent(new Event('change'));
      }
    });
  });
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
