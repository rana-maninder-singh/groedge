<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'Operational Maturity Self-Assessment | GroEdge';
$page_description = 'Evaluate your organisation across 5 operational dimensions. Get a scored maturity profile in under 5 minutes.';
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
.tool-question{background:#fff;border:1px solid var(--line);border-left:4px solid var(--accent);border-radius:6px;padding:20px 24px;margin-bottom:18px}
.tool-question h3{margin:0 0 6px;font-size:1rem;color:var(--ink)}
.tool-question .dim-label{font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;color:var(--accent-deep);margin-bottom:8px;font-weight:600}
.tool-options{display:flex;flex-direction:column;gap:8px;margin-top:12px}
.tool-option{display:flex;align-items:center;cursor:pointer;padding:10px 14px;border:1px solid var(--line);border-radius:6px;transition:all .2s}
.tool-option:hover{border-color:var(--accent);background:#f8fdf2}
.tool-option input[type=radio]{margin-right:10px;accent-color:var(--accent-deep)}
.tool-option input:checked + span{font-weight:600;color:var(--accent-deep)}
.tool-option input:checked ~ .opt-check{opacity:1}
.tool-option.selected{border-color:var(--accent-deep);background:#f0f9e4}
.tool-nav{display:flex;justify-content:space-between;margin-top:28px}
.tool-nav button{padding:12px 30px;border:none;border-radius:6px;font-size:.95rem;cursor:pointer;font-weight:600;transition:all .2s}
.tool-nav .btn-back{background:var(--line);color:var(--ink)}
.tool-nav .btn-back:hover{background:#bcc8d4}
.tool-nav .btn-next{background:var(--accent);color:var(--ink)}
.tool-nav .btn-next:hover{background:var(--accent-deep);color:#fff}
.tool-nav .btn-next:disabled{opacity:.4;cursor:not-allowed}
.tool-results{display:none;text-align:center}
.tool-results.active{display:block}
.tool-results h2{font-size:1.6rem;margin:0 0 8px;color:var(--ink)}
.tool-score-big{font-size:3rem;font-weight:700;color:var(--accent-deep);margin:10px 0}
.tool-classification{display:inline-block;padding:8px 20px;border-radius:20px;font-weight:600;font-size:.95rem;margin-bottom:25px}
.tool-dim-bars{text-align:left;margin:25px 0}
.tool-dim-bar{margin-bottom:14px}
.tool-dim-bar .label-row{display:flex;justify-content:space-between;margin-bottom:4px;font-size:.85rem}
.tool-dim-bar .label-row .dim-name{font-weight:600;color:var(--ink)}
.tool-dim-bar .label-row .dim-score{color:var(--accent-deep);font-weight:700}
.tool-dim-bar .bar-track{width:100%;height:14px;background:var(--line);border-radius:7px;overflow:hidden}
.tool-dim-bar .bar-fill{height:100%;border-radius:7px;transition:width 1s ease;width:0}
.tool-dim-bar .dim-level{font-size:.75rem;color:#888;margin-top:2px}
.tool-breakdown{background:#fff;border:1px solid var(--line);border-radius:8px;padding:20px;margin:20px 0;text-align:left}
.tool-breakdown h3{margin:0 0 12px;font-size:1rem;color:var(--ink)}
.tool-breakdown-item{display:flex;align-items:center;padding:8px 0;border-bottom:1px solid #eee}
.tool-breakdown-item:last-child{border-bottom:none}
.tool-breakdown-item .q-num{font-weight:700;color:var(--accent-deep);margin-right:12px;min-width:24px}
.tool-breakdown-item .q-text{flex:1;font-size:.85rem}
.tool-breakdown-item .q-ans{font-weight:600;color:var(--ink);font-size:.85rem}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>Operational Maturity Self-Assessment</h1>
    <p>Answer 10 questions across 5 dimensions to understand where your operations stand — and where to focus next.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Question 0 of 10</div>
  </div>

  <form id="maturityForm">
    <div class="tool-step" id="step1">
      <div class="tool-question">
        <div class="dim-label">Dimension 1 — Leadership &amp; Strategy</div>
        <h3>Q1. How clearly is your operational strategy defined and communicated?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q1" value="1" required><span>No formal strategy exists</span></label>
          <label class="tool-option"><input type="radio" name="q1" value="2"><span>Strategy exists verbally only</span></label>
          <label class="tool-option"><input type="radio" name="q1" value="3"><span>Fully documented and shared with leadership</span></label>
          <label class="tool-option"><input type="radio" name="q1" value="4"><span>Cascaded to the shop floor with visual displays</span></label>
        </div>
      </div>
      <div class="tool-question">
        <div class="dim-label">Dimension 1 — Leadership &amp; Strategy</div>
        <h3>Q2. How often does leadership review operational performance?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q2" value="1" required><span>Ad hoc / only when problems arise</span></label>
          <label class="tool-option"><input type="radio" name="q2" value="2"><span>Quarterly reviews</span></label>
          <label class="tool-option"><input type="radio" name="q2" value="3"><span>Monthly reviews with structured agenda</span></label>
          <label class="tool-option"><input type="radio" name="q2" value="4"><span>Weekly gemba walks and performance reviews</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-question">
        <div class="dim-label">Dimension 2 — Process Excellence</div>
        <h3>Q3. Do you have documented standard work for critical operations?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q3" value="1" required><span>None — work is tribal knowledge</span></label>
          <label class="tool-option"><input type="radio" name="q3" value="2"><span>Some critical processes documented</span></label>
          <label class="tool-option"><input type="radio" name="q3" value="3"><span>Most processes documented</span></label>
          <label class="tool-option"><input type="radio" name="q3" value="4"><span>All processes with visual controls at workstations</span></label>
        </div>
      </div>
      <div class="tool-question">
        <div class="dim-label">Dimension 2 — Process Excellence</div>
        <h3>Q4. How are bottlenecks identified and resolved?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q4" value="1" required><span>Firefighting — wait until it hurts</span></label>
          <label class="tool-option"><input type="radio" name="q4" value="2"><span>Reactive analysis after incidents</span></label>
          <label class="tool-option"><input type="radio" name="q4" value="3"><span>Proactive monitoring via production data</span></label>
          <label class="tool-option"><input type="radio" name="q4" value="4"><span>Predictive — data flags issues before impact</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step3">
      <div class="tool-question">
        <div class="dim-label">Dimension 3 — People &amp; Capability</div>
        <h3>Q5. How structured is your supervisor development programme?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q5" value="1" required><span>No formal programme</span></label>
          <label class="tool-option"><input type="radio" name="q5" value="2"><span>Informal on-the-job training only</span></label>
          <label class="tool-option"><input type="radio" name="q5" value="3"><span>Structured programme but incomplete coverage</span></label>
          <label class="tool-option"><input type="radio" name="q5" value="4"><span>Comprehensive academy with assessments and progression</span></label>
        </div>
      </div>
      <div class="tool-question">
        <div class="dim-label">Dimension 3 — People &amp; Capability</div>
        <h3>Q6. Is a problem-solving methodology used consistently?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q6" value="1" required><span>No — problems are addressed by gut feel</span></label>
          <label class="tool-option"><input type="radio" name="q6" value="2"><span>Ad hoc use of root cause analysis</span></label>
          <label class="tool-option"><input type="radio" name="q6" value="3"><span>Some teams use A3 / 8D / 5-Why consistently</span></label>
          <label class="tool-option"><input type="radio" name="q6" value="4"><span>Plant-wide standard methodology with tracking</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step4">
      <div class="tool-question">
        <div class="dim-label">Dimension 4 — Technology &amp; Data</div>
        <h3>Q7. How integrated are your operational systems (ERP, MES, WMS)?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q7" value="1" required><span>Spreadsheets and paper-based tracking</span></label>
          <label class="tool-option"><input type="radio" name="q7" value="2"><span>Some systems in place but siloed</span></label>
          <label class="tool-option"><input type="radio" name="q7" value="3"><span>Mostly integrated with manual bridges</span></label>
          <label class="tool-option"><input type="radio" name="q7" value="4"><span>Fully integrated real-time data flow</span></label>
        </div>
      </div>
      <div class="tool-question">
        <div class="dim-label">Dimension 4 — Technology &amp; Data</div>
        <h3>Q8. Is real-time production data visible to operators?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q8" value="1" required><span>No — data is only in reports</span></label>
          <label class="tool-option"><input type="radio" name="q8" value="2"><span>Supervisor-level access only</span></label>
          <label class="tool-option"><input type="radio" name="q8" value="3"><span>Shift-level boards updated each shift</span></label>
          <label class="tool-option"><input type="radio" name="q8" value="4"><span>Live shop floor displays with KPIs</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step5">
      <div class="tool-question">
        <div class="dim-label">Dimension 5 — Metrics &amp; Improvement</div>
        <h3>Q9. How do you track operational KPIs?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q9" value="1" required><span>Manual tracking / not regularly</span></label>
          <label class="tool-option"><input type="radio" name="q9" value="2"><span>Periodic Excel reports (weekly / monthly)</span></label>
          <label class="tool-option"><input type="radio" name="q9" value="3"><span>Live dashboards with automated data feeds</span></label>
          <label class="tool-option"><input type="radio" name="q9" value="4"><span>Predictive analytics with AI-driven insights</span></label>
        </div>
      </div>
      <div class="tool-question">
        <div class="dim-label">Dimension 5 — Metrics &amp; Improvement</div>
        <h3>Q10. How structured is your continuous improvement programme?</h3>
        <div class="tool-options">
          <label class="tool-option"><input type="radio" name="q10" value="1" required><span>No formal programme</span></label>
          <label class="tool-option"><input type="radio" name="q10" value="2"><span>Occasional kaizen events</span></label>
          <label class="tool-option"><input type="radio" name="q10" value="3"><span>CI embedded in daily work routines</span></label>
          <label class="tool-option"><input type="radio" name="q10" value="4"><span>Self-sustaining culture of continuous improvement</span></label>
        </div>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your Maturity Profile</h2>
    <div class="tool-score-big" id="overallScore"></div>
    <div class="tool-classification" id="classification"></div>

    <div class="tool-dim-bars" id="dimBars"></div>

    <div class="tool-breakdown" id="answersBreakdown">
      <h3>Your Answers</h3>
      <div id="answersList"></div>
    </div>

    <div class="cta-box">
      <h3>Want to move from "Developing" to "Established" — fast?</h3>
      <p>Our maturity acceleration programme uses this assessment as the baseline. We map a 90-day roadmap for each dimension.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  const dims = [
    {name:'Leadership & Strategy',qs:['q1','q2']},
    {name:'Process Excellence',qs:['q3','q4']},
    {name:'People & Capability',qs:['q5','q6']},
    {name:'Technology & Data',qs:['q7','q8']},
    {name:'Metrics & Improvement',qs:['q9','q10']}
  ];
  const qLabels = {
    q1:'Strategy definition and communication',
    q2:'Leadership performance review cadence',
    q3:'Standard work documentation',
    q4:'Bottleneck identification and resolution',
    q5:'Supervisor development programme',
    q6:'Problem-solving methodology usage',
    q7:'System integration (ERP/MES/WMS)',
    q8:'Real-time data visibility for operators',
    q9:'KPI tracking approach',
    q10:'Continuous improvement programme'
  };
  const answers = {q1:'Not defined',q2:'Ad hoc',q3:'None',q4:'Firefighting',q5:'None',q6:'No',q7:'Spreadsheets',q8:'No',q9:'Manual',q10:'No formal programme'};
  let currentStep = 0;
  const totalSteps = 5;
  const allQ = ['q1','q2','q3','q4','q5','q6','q7','q8','q9','q10'];

  function showStep(i){
    document.querySelectorAll('.tool-step').forEach(s=>s.classList.remove('active'));
    document.getElementById('step'+(i+1)).classList.add('active');
    document.getElementById('btnBack').style.display = i===0?'none':'inline-block';
    const btn = document.getElementById('btnNext');
    btn.textContent = i===totalSteps-1?'View Results':'Next';
    const pct = ((i+1)/totalSteps)*100;
    document.getElementById('progressFill').style.width = pct+'%';
    document.getElementById('progressLabel').textContent = 'Step '+(i+1)+' of '+totalSteps;
  }

  window.nextStep = function(){
    const stepQs = dims[currentStep].qs;
    for(const q of stepQs){
      if(!document.querySelector('input[name="'+q+'"]:checked')){
        document.querySelector('input[name="'+q+'"]').closest('.tool-question').style.boxShadow='0 0 0 2px #e74c3c';
        setTimeout(()=>document.querySelector('input[name="'+q+'"]').closest('.tool-question').style.boxShadow='',1500);
        return;
      }
    }
    stepQs.forEach(q=>{
      const checked = document.querySelector('input[name="'+q+'"]:checked');
      if(checked) answers[q] = checked.parentElement.querySelector('span').textContent;
    });
    if(currentStep < totalSteps-1){
      currentStep++;
      showStep(currentStep);
    } else {
      showResults();
    }
  };

  window.prevStep = function(){
    if(currentStep>0){currentStep--;showStep(currentStep);}
  };

  function getLevel(score){
    if(score<=1.5) return {label:'Initial',color:'#e74c3c',bg:'#fdeaea'};
    if(score<=2.5) return {label:'Developing',color:'#e8a317',bg:'#fef6e4'};
    if(score<=3.5) return {label:'Established',color:'#27ae60',bg:'#e8f8f0'};
    return {label:'World Class',color:'#8bc53f',bg:'#f0f9e4'};
  }

  function showResults(){
    document.getElementById('maturityForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    let totalScore = 0;
    const dimScores = [];
    const html = [];

    dims.forEach(d=>{
      let sum=0;
      d.qs.forEach(q=>{
        const v = parseInt(document.querySelector('input[name="'+q+'"]:checked').value);
        sum+=v;
      });
      const avg = sum/d.qs.length;
      dimScores.push({name:d.name,score:avg});
      totalScore+=avg;
    });

    const overall = (totalScore/5)*25;
    const level = getLevel(totalScore/5);
    document.getElementById('overallScore').textContent = Math.round(overall)+' / 100';
    const cls = document.getElementById('classification');
    cls.textContent = level.label;
    cls.style.background = level.bg;
    cls.style.color = level.color;

    let barsHtml = '';
    dimScores.forEach(d=>{
      const pct = (d.score/4)*100;
      const lv = getLevel(d.score);
      barsHtml += '<div class="tool-dim-bar">'+
        '<div class="label-row"><span class="dim-name">'+d.name+'</span><span class="dim-score">'+d.score.toFixed(1)+' / 4.0</span></div>'+
        '<div class="bar-track"><div class="bar-fill" data-width="'+pct+'" style="background:'+lv.color+'"></div></div>'+
        '<div class="dim-level">'+lv.label+'</div></div>';
    });
    document.getElementById('dimBars').innerHTML = barsHtml;

    let ansHtml = '';
    allQ.forEach((q,i)=>{
      ansHtml += '<div class="tool-breakdown-item"><span class="q-num">Q'+(i+1)+'</span><span class="q-text">'+qLabels[q]+'</span><span class="q-ans">'+answers[q]+'</span></div>';
    });
    document.getElementById('answersList').innerHTML = ansHtml;

    setTimeout(()=>{
      document.querySelectorAll('.bar-fill').forEach(b=>{
        b.style.width = b.dataset.width+'%';
      });
    },100);

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
