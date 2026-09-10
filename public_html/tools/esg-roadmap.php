<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'ESG Compliance Roadmap | GroEdge';
$page_description = 'Assess your Environment, Social, and Governance readiness. Get a compliance roadmap and estimated timeline to BRSR readiness.';
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
.tool-section-title{font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:14px;padding-bottom:8px;border-bottom:2px solid var(--accent)}
.tool-toggle-group{display:flex;flex-direction:column;gap:10px}
.tool-toggle-item{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border:1px solid var(--line);border-radius:6px;transition:all .2s;background:#fff}
.tool-toggle-item span{flex:1;font-size:.9rem;color:var(--ink)}
.tool-toggle{position:relative;width:52px;height:28px;flex-shrink:0}
.tool-toggle input{opacity:0;width:0;height:0;position:absolute}
.tool-toggle .slider{position:absolute;cursor:pointer;inset:0;background:var(--line);border-radius:14px;transition:all .3s}
.tool-toggle .slider::before{content:'';position:absolute;height:22px;width:22px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:all .3s}
.tool-toggle input:checked + .slider{background:var(--accent)}
.tool-toggle input:checked + .slider::before{transform:translateX(24px)}
.tool-toggle-item.done{border-color:var(--accent-deep);background:#f8fdf2}
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
.tool-gauges-row{display:flex;justify-content:center;flex-wrap:wrap;gap:24px;margin:25px 0}
.big-gauge{width:200px;text-align:center}
.big-gauge .gauge-ring{width:160px;height:160px;border-radius:50%;position:relative;margin:0 auto 10px}
.big-gauge .gauge-ring::after{content:'';position:absolute;top:22px;left:22px;right:22px;bottom:22px;background:#fff;border-radius:50%}
.big-gauge .gauge-center{position:absolute;top:0;left:0;right:0;bottom:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:1}
.big-gauge .gauge-val{font-size:1.6rem;font-weight:700;color:var(--ink)}
.big-gauge .gauge-sub{font-size:.7rem;color:#888}
.big-gauge .gauge-name{font-size:.9rem;font-weight:600;color:var(--ink);margin-top:4px}
.timeline-box{background:#fff;border:1px solid var(--line);border-radius:8px;padding:20px;margin:20px 0;text-align:left}
.timeline-box h3{margin:0 0 6px;font-size:1rem;color:var(--ink)}
.timeline-box .months{font-size:1.4rem;font-weight:700;color:var(--accent-deep);margin-bottom:12px}
.action-list{margin:0;padding-left:20px}
.action-list li{margin-bottom:10px;font-size:.88rem;color:var(--ink)}
.action-list li strong{color:var(--accent-deep)}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>ESG Compliance Roadmap</h1>
    <p>Toggle 12 items across Environment, Social, and Governance. Get your readiness score, recommended actions, and estimated timeline to BRSR compliance.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Step 1 of 2</div>
  </div>

  <form id="esgForm">
    <div class="tool-step active" id="step1">
      <div class="tool-section-title">Environment</div>
      <div class="tool-toggle-group">
        <div class="tool-toggle-item">
          <span>Energy consumption baselined and tracked</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_e1" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Water usage mapped and meters installed</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_e2" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Waste segregation and recycling programme in place</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_e3" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Carbon footprint estimated (Scope 1 and 2)</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_e4" value="yes"><span class="slider"></span></label>
        </div>
      </div>

      <div class="tool-section-title" style="margin-top:24px">Social</div>
      <div class="tool-toggle-group">
        <div class="tool-toggle-item">
          <span>Worker safety metrics tracked (LTIFR, near-miss reporting)</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_s1" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Training hours per employee documented</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_s2" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Diversity and inclusion policy in place</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_s3" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Community engagement programme active</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_s4" value="yes"><span class="slider"></span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-section-title">Governance</div>
      <div class="tool-toggle-group">
        <div class="tool-toggle-item">
          <span>Board-level ESG oversight established</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_g1" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>BRSR / ESG reporting framework selected</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_g2" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Data collection processes for ESG metrics defined</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_g3" value="yes"><span class="slider"></span></label>
        </div>
        <div class="tool-toggle-item">
          <span>Third-party ESG audit conducted or scheduled</span>
          <label class="tool-toggle"><input type="checkbox" name="esg_g4" value="yes"><span class="slider"></span></label>
        </div>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your ESG Compliance Roadmap</h2>
    <div class="tool-score-big" id="overallScore"></div>
    <div class="tool-classification" id="classification"></div>

    <div class="tool-gauges-row" id="gaugesRow"></div>

    <div class="timeline-box">
      <h3>Estimated Time to BRSR Compliance Readiness</h3>
      <div class="months" id="timelineMonths"></div>
      <ul class="action-list" id="actionList"></ul>
    </div>

    <div class="cta-box">
      <h3>Accelerate your ESG journey</h3>
      <p>Our ESG readiness programme helps listed companies become BRSR-compliant in structured phases — from gap assessment to first report filing.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  const sections=[
    {name:'Environment',keys:['esg_e1','esg_e2','esg_e3','esg_e4'],actions:['Install energy meters and begin monthly consumption tracking','Map water flow, install sub-meters at critical points','Establish waste segregation at source, tie up with recyclers','Engage an consultant to estimate Scope 1 and 2 carbon emissions']},
    {name:'Social',keys:['esg_s1','esg_s2','esg_s3','esg_s4'],actions:['Set up safety dashboards with LTIFR and near-miss tracking','Implement an LMS to track training hours per employee','Draft and publish a diversity and inclusion policy','Launch a structured CSR/community engagement programme']},
    {name:'Governance',keys:['esg_g1','esg_g2','esg_g3','esg_g4'],actions:['Form a board-level ESG committee with defined charter','Select BRSR / GRI / SASB as your reporting framework','Define data owners, frequency, and collection tools for each ESG metric','Engage a third-party auditor for ESG readiness assessment']}
  ];
  let step=0;
  const totalSteps=2;

  function showStep(i){
    document.querySelectorAll('.tool-step').forEach((s,idx)=>{s.classList.toggle('active',idx===i)});
    document.getElementById('btnBack').style.display=i===0?'none':'inline-block';
    document.getElementById('btnNext').textContent=i===totalSteps-1?'View Results':'Next';
    document.getElementById('progressFill').style.width=((i+1)/totalSteps*100)+'%';
    document.getElementById('progressLabel').textContent='Step '+(i+1)+' of '+totalSteps;
  }

  window.nextStep=function(){
    if(step<totalSteps-1){step++;showStep(step);}
    else showResults();
  };

  window.prevStep=function(){if(step>0){step--;showStep(step);}};

  function getLevel(pct){
    if(pct<25) return {label:'Early Stage',color:'#e74c3c',bg:'#fdeaea'};
    if(pct<50) return {label:'Getting Started',color:'#e8a317',bg:'#fef6e4'};
    if(pct<75) return {label:'Progressing',color:'#27ae60',bg:'#e8f8f0'};
    return {label:'ESG-Ready',color:'#8bc53f',bg:'#f0f9e4'};
  }

  function showResults(){
    document.getElementById('esgForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    let totalYes=0;
    const secScores=[];

    sections.forEach(s=>{
      let yes=0;
      s.keys.forEach(k=>{
        if(document.querySelector('input[name="'+k+'"]').checked) yes++;
      });
      secScores.push({name:s.name,yes:yes,total:4,pct:(yes/4)*100,actions:s.actions,keys:s.keys});
      totalYes+=yes;
    });

    const overallPct=Math.round((totalYes/12)*100);
    const overallLevel=getLevel(overallPct);

    document.getElementById('overallScore').textContent=overallPct+'%';
    document.getElementById('overallScore').style.color=overallLevel.color;
    const cls=document.getElementById('classification');
    cls.textContent=overallLevel.label;
    cls.style.background=overallLevel.bg;
    cls.style.color=overallLevel.color;

    let gaugesHtml='';
    secScores.forEach(s=>{
      const deg=Math.round(s.pct*3.6);
      const color=s.pct>=75?'#8bc53f':s.pct>=50?'#27ae60':s.pct>=25?'#e8a317':'#e74c3c';
      gaugesHtml+='<div class="big-gauge">'+
        '<div class="gauge-ring" style="background:conic-gradient('+color+' 0deg '+deg+'deg, #d0dae4 '+deg+'deg 360deg)">'+
        '<div class="gauge-center"><span class="gauge-val">'+s.yes+'/4</span><span class="gauge-sub">'+Math.round(s.pct)+'%</span></div></div>'+
        '<div class="gauge-name">'+s.name+'</div></div>';
    });
    document.getElementById('gaugesRow').innerHTML=gaugesHtml;

    const remaining=12-totalYes;
    let months=0;
    if(remaining<=2) months=1;
    else if(remaining<=4) months=3;
    else if(remaining<=6) months=6;
    else if(remaining<=9) months=9;
    else months=12;
    document.getElementById('timelineMonths').textContent='~'+months+' months';

    let actionHtml='';
    secScores.forEach(s=>{
      s.keys.forEach((k,i)=>{
        if(!document.querySelector('input[name="'+k+'"]').checked){
          actionHtml+='<li><strong>'+s.name+':</strong> '+s.actions[i]+'</li>';
        }
      });
    });
    if(!actionHtml) actionHtml='<li>All items addressed. You are well-positioned for BRSR compliance.</li>';
    document.getElementById('actionList').innerHTML=actionHtml;

    document.getElementById('results').scrollIntoView({behavior:'smooth'});
  }

  showStep(0);

  document.querySelectorAll('.tool-toggle input').forEach(inp=>{
    inp.addEventListener('change',function(){
      const item=this.closest('.tool-toggle-item');
      item.classList.toggle('done',this.checked);
    });
  });
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
