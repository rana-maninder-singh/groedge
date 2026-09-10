<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'Lean Readiness Scorecard | GroEdge';
$page_description = 'Score your organisation across 5 lean dimensions. Get a readiness percentage and recommended next steps.';
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
.tool-dim-title{font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:12px;padding-bottom:8px;border-bottom:2px solid var(--accent)}
.tool-question{background:#fff;border:1px solid var(--line);border-left:4px solid var(--accent);border-radius:6px;padding:16px 20px;margin-bottom:14px}
.tool-question h3{margin:0 0 12px;font-size:.95rem;color:var(--ink)}
.tool-options{display:flex;flex-direction:column;gap:8px}
.tool-option{display:flex;align-items:center;cursor:pointer;padding:10px 14px;border:1px solid var(--line);border-radius:6px;transition:all .2s;font-size:.85rem}
.tool-option:hover{border-color:var(--accent);background:#f8fdf2}
.tool-option input{margin-right:10px;accent-color:var(--accent-deep)}
.tool-option input:checked + span{font-weight:600;color:var(--accent-deep)}
.tool-option:has(input:checked){border-color:var(--accent-deep);background:#f0f9e4}
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
.tool-circular-gauges{display:flex;justify-content:center;flex-wrap:wrap;gap:20px;margin:25px 0}
.circular-gauge{width:140px;text-align:center}
.circular-gauge .ring{width:120px;height:120px;border-radius:50%;position:relative;margin:0 auto 8px}
.circular-gauge .ring::after{content:'';position:absolute;top:15px;left:15px;right:15px;bottom:15px;background:#fff;border-radius:50%}
.circular-gauge .ring-label{position:absolute;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;z-index:1}
.circular-gauge .ring-value{font-size:1.2rem;font-weight:700;color:var(--ink)}
.circular-gauge .ring-name{font-size:.8rem;color:#666;font-weight:600}
.next-steps{background:#fff;border:1px solid var(--line);border-radius:8px;padding:20px;margin:20px 0;text-align:left}
.next-steps h3{margin:0 0 12px;font-size:1rem;color:var(--ink)}
.next-steps ul{margin:0;padding-left:20px}
.next-steps li{margin-bottom:8px;font-size:.9rem;color:var(--ink)}
.next-steps li strong{color:var(--accent-deep)}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>Lean Readiness Scorecard</h1>
    <p>10 questions across 5 lean dimensions. Rate your agreement and discover your readiness level with recommended next steps.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Step 1 of 2</div>
  </div>

  <form id="leanForm">
    <div class="tool-step active" id="step1">
      <div class="tool-dim-title">1. Culture</div>
      <div class="tool-question">
        <h3>Management is visibly committed to lean principles</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean1" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean1" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean1" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean1" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean1" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Employees at all levels are engaged in improvement activities</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean2" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean2" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean2" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean2" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean2" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">2. Process</div>
      <div class="tool-question">
        <h3>Standard work exists for all critical processes</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean3" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean3" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean3" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean3" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean3" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Waste (muda) is identified regularly across operations</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean4" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean4" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean4" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean4" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean4" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-dim-title">3. People</div>
      <div class="tool-question">
        <h3>Training hours per employee are tracked and managed</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean5" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean5" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean5" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean5" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean5" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Multi-skilling is actively practised across the workforce</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean6" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean6" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean6" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean6" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean6" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">4. Systems</div>
      <div class="tool-question">
        <h3>Visual management tools are used on the shop floor</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean7" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean7" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean7" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean7" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean7" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Daily management routines (tier meetings, escalation) are in place</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean8" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean8" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean8" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean8" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean8" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">5. Metrics</div>
      <div class="tool-question">
        <h3>Cycle time and takt time are tracked for key processes</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean9" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean9" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean9" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean9" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean9" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Improvement targets are set and reviewed regularly</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="lean10" value="1" required><span>Strongly Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean10" value="2"><span>Disagree</span></label>
          <label class="tool-option"><input type="radio" name="lean10" value="3"><span>Neutral</span></label>
          <label class="tool-option"><input type="radio" name="lean10" value="4"><span>Agree</span></label>
          <label class="tool-option"><input type="radio" name="lean10" value="5"><span>Strongly Agree</span></label>
        </div>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your Lean Readiness Profile</h2>
    <div class="tool-score-big" id="overallScore"></div>
    <div class="tool-classification" id="classification"></div>

    <div class="tool-circular-gauges" id="gauges"></div>

    <div class="next-steps" id="nextStepsBox">
      <h3>Recommended Next Steps</h3>
      <ul id="nextStepsList"></ul>
    </div>

    <div class="cta-box">
      <h3>Ready to start your lean journey?</h3>
      <p>Our lean readiness programme begins with a value stream mapping workshop and builds capability that sustains beyond the engagement.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  const dims=[
    {name:'Culture',qs:['lean1','lean2'],action:'Begin with lean leadership workshops and establish a daily management system'},
    {name:'Process',qs:['lean3','lean4'],action:'Conduct value stream mapping and establish standard work for top 5 processes'},
    {name:'People',qs:['lean5','lean6'],action:'Implement a skills matrix and launch a structured cross-training programme'},
    {name:'Systems',qs:['lean7','lean8'],action:'Deploy visual management boards and establish tiered daily accountability meetings'},
    {name:'Metrics',qs:['lean9','lean10'],action:'Set up a metrics hierarchy with targets reviewed at daily, weekly, and monthly tiers'}
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
    const stepQs=dims[step===0?0:step*2]||dims[0];
    const qRange=step===0?[1,2,3,4]:[5,6,7,8,9,10];
    for(const q of qRange){
      if(!document.querySelector('input[name="lean'+q+'"]:checked')){
        document.querySelector('input[name="lean'+q+'"]').closest('.tool-question').style.boxShadow='0 0 0 2px #e74c3c';
        setTimeout(()=>document.querySelector('input[name="lean'+q+'"]').closest('.tool-question').style.boxShadow='',1500);
        return;
      }
    }
    if(step<totalSteps-1){step++;showStep(step);}
    else showResults();
  };

  window.prevStep=function(){if(step>0){step--;showStep(step);}};

  function getLevel(pct){
    if(pct<40) return {label:'Not Ready',color:'#e74c3c',bg:'#fdeaea'};
    if(pct<60) return {label:'Getting Ready',color:'#e8a317',bg:'#fef6e4'};
    if(pct<80) return {label:'Ready',color:'#27ae60',bg:'#e8f8f0'};
    return {label:'Lean Leader',color:'#8bc53f',bg:'#f0f9e4'};
  }

  function showResults(){
    document.getElementById('leanForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    let totalScore=0;
    const dimScores=[];

    dims.forEach(d=>{
      let sum=0;
      d.qs.forEach(q=>{
        sum+=parseInt(document.querySelector('input[name="'+q+'"]:checked').value);
      });
      const avg=sum/d.qs.length;
      dimScores.push({name:d.name,score:avg,pct:(avg/5)*100,action:d.action});
      totalScore+=avg;
    });

    const overallPct=Math.round((totalScore/25)*100);
    const overallLevel=getLevel(overallPct);

    document.getElementById('overallScore').textContent=overallPct+'%';
    document.getElementById('overallScore').style.color=overallLevel.color;
    const cls=document.getElementById('classification');
    cls.textContent=overallLevel.label;
    cls.style.background=overallLevel.bg;
    cls.style.color=overallLevel.color;

    let gaugesHtml='';
    dimScores.forEach(d=>{
      const pct=Math.round(d.pct);
      const deg=Math.round(pct*3.6);
      const color=pct>=80?'#8bc53f':pct>=60?'#27ae60':pct>=40?'#e8a317':'#e74c3c';
      gaugesHtml+='<div class="circular-gauge">'+
        '<div class="ring" style="background:conic-gradient('+color+' 0deg '+deg+'deg, #d0dae4 '+deg+'deg 360deg)">'+
        '<div class="ring-label"><span class="ring-value">'+pct+'%</span></div></div>'+
        '<div class="ring-name">'+d.name+'</div></div>';
    });
    document.getElementById('gauges').innerHTML=gaugesHtml;

    const sorted=[...dimScores].sort((a,b)=>a.pct-b.pct);
    let stepsHtml='';
    sorted.slice(0,3).forEach(d=>{
      stepsHtml+='<li><strong>'+d.name+' ('+Math.round(d.pct)+'%)</strong> — '+d.action+'</li>';
    });
    document.getElementById('nextStepsList').innerHTML=stepsHtml;

    document.getElementById('results').scrollIntoView({behavior:'smooth'});
  }

  showStep(0);

  document.querySelectorAll('.tool-option input').forEach(r=>{
    r.addEventListener('change',function(){
      this.closest('.tool-options').querySelectorAll('.tool-option').forEach(o=>o.classList.remove('selected'));
      this.closest('.tool-option').classList.add('selected');
    });
  });
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
