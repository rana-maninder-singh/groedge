<?php
define('DATA_DIR', __DIR__ . '/../data');
require_once __DIR__ . '/../includes/config.php';
$cfg = get_config();
$base_path = '../';
$page_title = 'Supply Chain Health Checklist | GroEdge';
$page_description = 'Assess your supply chain across 8 dimensions. Get a health score and prioritised improvement actions.';
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
.tool-dim-title{font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:4px;padding-bottom:8px;border-bottom:2px solid var(--accent)}
.tool-question{background:#fff;border:1px solid var(--line);border-left:4px solid var(--accent);border-radius:6px;padding:16px 20px;margin-bottom:14px}
.tool-question h3{margin:0 0 10px;font-size:.95rem;color:var(--ink)}
.tool-check-group{display:flex;gap:10px;flex-wrap:wrap}
.tool-check-group label{flex:1;min-width:100px;padding:10px 14px;border:1px solid var(--line);border-radius:6px;cursor:pointer;text-align:center;transition:all .2s;font-size:.85rem}
.tool-check-group label:hover{border-color:var(--accent)}
.tool-check-group input{margin-right:6px}
.tool-check-group input:checked + span{font-weight:600;color:var(--accent-deep)}
.tool-check-group label:has(input:checked){border-color:var(--accent-deep);background:#f0f9e4}
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
.tool-classification{display:inline-block;padding:8px 20px;border-radius:20px;font-weight:600;font-size:.95rem;margin-bottom:20px}
.tool-dim-bars{text-align:left;margin:25px 0}
.tool-dim-bar{margin-bottom:14px}
.tool-dim-bar .label-row{display:flex;justify-content:space-between;margin-bottom:4px;font-size:.85rem}
.tool-dim-bar .label-row .dim-name{font-weight:600;color:var(--ink)}
.tool-dim-bar .label-row .dim-score{font-weight:700}
.tool-dim-bar .bar-track{width:100%;height:14px;background:var(--line);border-radius:7px;overflow:hidden}
.tool-dim-bar .bar-fill{height:100%;border-radius:7px;transition:width 1s ease;width:0}
.priorities-box{background:#fff;border:1px solid var(--line);border-radius:8px;padding:20px;margin:20px 0;text-align:left}
.priorities-box h3{margin:0 0 12px;font-size:1rem;color:var(--ink)}
.priorities-box ol{margin:0;padding-left:20px}
.priorities-box li{margin-bottom:10px;font-size:.9rem;color:var(--ink)}
.priorities-box li strong{color:var(--accent-deep)}
.cta-box{background:var(--ink);color:#fff;padding:30px;border-radius:8px;margin-top:30px;text-align:center}
.cta-box h3{margin:0 0 8px;color:var(--accent)}
.cta-box p{margin:0 0 16px;opacity:.85;font-size:.9rem}
.cta-box a{display:inline-block;padding:12px 28px;background:var(--accent);color:var(--ink);text-decoration:none;border-radius:6px;font-weight:600;transition:background .2s}
.cta-box a:hover{background:var(--accent-deep);color:#fff}
</style>

<div class="tool-container">
  <div class="tool-banner">
    <h1>Supply Chain Health Checklist</h1>
    <p>Evaluate 8 supply chain dimensions with 24 targeted questions. Get your health score and top improvement priorities.</p>
  </div>

  <div class="tool-progress-wrap">
    <div class="tool-progress"><div class="tool-progress-fill" id="progressFill" style="width:0%"></div></div>
    <div class="tool-progress-label" id="progressLabel">Step 1 of 4</div>
  </div>

  <form id="scForm">
    <div class="tool-step active" id="step1">
      <div class="tool-dim-title">1. Demand Planning</div>
      <div class="tool-question">
        <h3>Forecast accuracy is tracked and regularly reviewed</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d1" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d1" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d1" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>A formal S&OP process is in place</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d1" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d1" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d1" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Demand sensing tools or methods are used</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d1" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d1" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d1" value="2"><span>Yes</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">2. Inventory Management</div>
      <div class="tool-question">
        <h3>Inventory policy is defined and documented</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d2" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d2" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d2" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>ABC classification is applied to SKUs</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d2" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d2" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d2" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Safety stock is optimised with data</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d2" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d2" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d2" value="2"><span>Yes</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step2">
      <div class="tool-dim-title">3. Supplier Management</div>
      <div class="tool-question">
        <h3>Suppliers are scorecarded on performance</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d3" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d3" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d3" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Supplier development programme exists</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d3" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d3" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d3" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Supply risk assessment is conducted</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d3" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d3" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d3" value="2"><span>Yes</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">4. Warehouse Efficiency</div>
      <div class="tool-question">
        <h3>Warehouse layout is optimised for flow</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d4" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d4" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d4" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Slotting is reviewed periodically</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d4" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d4" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d4" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Pick-path is designed for efficiency</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d4" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d4" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d4" value="2"><span>Yes</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step3">
      <div class="tool-dim-title">5. Logistics Performance</div>
      <div class="tool-question">
        <h3>OTIF (On-Time In-Full) is tracked</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d5" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d5" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d5" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Route optimisation is applied</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d5" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d5" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d5" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Cost per order is tracked and benchmarked</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d5" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d5" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d5" value="2"><span>Yes</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">6. Technology Integration</div>
      <div class="tool-question">
        <h3>WMS is in use and operational</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d6" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d6" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d6" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>EDI is established with key suppliers</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d6" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d6" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d6" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Real-time visibility across the chain</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d6" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d6" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d6" value="2"><span>Yes</span></label>
        </div>
      </div>
    </div>

    <div class="tool-step" id="step4">
      <div class="tool-dim-title">7. Risk &amp; Resilience</div>
      <div class="tool-question">
        <h3>Contingency plans exist for disruptions</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d7" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d7" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d7" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Dual sourcing is practised for critical items</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d7" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d7" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d7" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Scenario testing / war-gaming is conducted</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d7" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d7" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d7" value="2"><span>Yes</span></label>
        </div>
      </div>

      <div class="tool-dim-title" style="margin-top:20px">8. Metrics &amp; Governance</div>
      <div class="tool-question">
        <h3>Supply chain KPIs are tracked and reported</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d8" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d8" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d8" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Regular review cadence for SC performance</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d8" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d8" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d8" value="2"><span>Yes</span></label>
        </div>
      </div>
      <div class="tool-question">
        <h3>Cross-functional alignment on SC goals</h3>
        <div class="tool-check-group">
          <label><input type="checkbox" name="sc_d8" value="0"><span>No</span></label>
          <label><input type="checkbox" name="sc_d8" value="1"><span>Partial</span></label>
          <label><input type="checkbox" name="sc_d8" value="2"><span>Yes</span></label>
        </div>
      </div>
    </div>
  </form>

  <div class="tool-nav">
    <button type="button" class="btn-back" id="btnBack" style="display:none" onclick="prevStep()">Back</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">Next</button>
  </div>

  <div class="tool-results" id="results">
    <h2>Your Supply Chain Health Score</h2>
    <div class="tool-score-big" id="overallScore"></div>
    <div class="tool-classification" id="classification"></div>

    <div class="tool-dim-bars" id="dimBars"></div>

    <div class="priorities-box" id="prioritiesBox">
      <h3>Top Improvement Priorities</h3>
      <ol id="priorityList"></ol>
    </div>

    <div class="cta-box">
      <h3>Build supply chain resilience that lasts</h3>
      <p>Our supply chain health programme moves you from "Needs Attention" to "Excellent" in structured phases. We start with a deep diagnostic.</p>
      <a href="../contact.php">Book a Free Consultation</a>
    </div>
  </div>
</div>

<script>
(function(){
  const dims = [
    {name:'Demand Planning',keys:['sc_d1','sc_d1','sc_d1']},
    {name:'Inventory Management',keys:['sc_d2','sc_d2','sc_d2']},
    {name:'Supplier Management',keys:['sc_d3','sc_d3','sc_d3']},
    {name:'Warehouse Efficiency',keys:['sc_d4','sc_d4','sc_d4']},
    {name:'Logistics Performance',keys:['sc_d5','sc_d5','sc_d5']},
    {name:'Technology Integration',keys:['sc_d6','sc_d6','sc_d6']},
    {name:'Risk & Resilience',keys:['sc_d7','sc_d7','sc_d7']},
    {name:'Metrics & Governance',keys:['sc_d8','sc_d8','sc_d8']}
  ];
  const stepDims = [[0,1],[2,3],[4,5],[6,7]];
  let step = 0;
  const totalSteps = 4;

  function showStep(i){
    document.querySelectorAll('.tool-step').forEach((s,idx)=>{s.classList.toggle('active',idx===i)});
    document.getElementById('btnBack').style.display = i===0?'none':'inline-block';
    document.getElementById('btnNext').textContent = i===totalSteps-1?'View Results':'Next';
    document.getElementById('progressFill').style.width = ((i+1)/totalSteps*100)+'%';
    document.getElementById('progressLabel').textContent = 'Step '+(i+1)+' of '+totalSteps;
  }

  function stepValid(i){
    const dimIdxs = stepDims[i];
    for(const di of dimIdxs){
      const inputs = document.querySelectorAll('input[name="sc_d'+(di+1)+'"]');
      let checked = 0;
      inputs.forEach(inp=>{if(inp.checked) checked++;});
      if(checked===0){
        const q = inputs[0].closest('.tool-question');
        q.style.boxShadow='0 0 0 2px #e74c3c';
        setTimeout(()=>q.style.boxShadow='',1500);
        return false;
      }
    }
    return true;
  }

  window.nextStep = function(){
    if(!stepValid(step)) return;
    if(step < totalSteps-1){step++;showStep(step);}
    else showResults();
  };

  window.prevStep = function(){if(step>0){step--;showStep(step);}};

  function getLevel(pct){
    if(pct<40) return {label:'Critical',color:'#e74c3c',bg:'#fdeaea'};
    if(pct<60) return {label:'Needs Attention',color:'#e8a317',bg:'#fef6e4'};
    if(pct<80) return {label:'Good',color:'#27ae60',bg:'#e8f8f0'};
    return {label:'Excellent',color:'#8bc53f',bg:'#f0f9e4'};
  }

  function showResults(){
    document.getElementById('scForm').style.display='none';
    document.querySelector('.tool-nav').style.display='none';
    document.getElementById('results').classList.add('active');
    document.getElementById('progressFill').style.width='100%';
    document.getElementById('progressLabel').textContent='Complete';

    const dimScores=[];
    let totalChecked=0;
    let totalMax=0;

    for(let i=1;i<=8;i++){
      const inputs=document.querySelectorAll('input[name="sc_d'+i+'"]:checked');
      let score=0;
      inputs.forEach(inp=>{score+=parseInt(inp.value);});
      const pct=(score/6)*100;
      dimScores.push({name:dims[i-1].name,score:score,max:6,pct:pct});
      totalChecked+=score;
      totalMax+=6;
    }

    const overallPct=Math.round((totalChecked/totalMax)*100);
    const overallLevel=getLevel(overallPct);

    document.getElementById('overallScore').textContent=overallPct+'%';
    document.getElementById('overallScore').style.color=overallLevel.color;
    const cls=document.getElementById('classification');
    cls.textContent=overallLevel.label;
    cls.style.background=overallLevel.bg;
    cls.style.color=overallLevel.color;

    let barsHtml='';
    dimScores.forEach(d=>{
      const lv=getLevel(d.pct);
      barsHtml+='<div class="tool-dim-bar">'+
        '<div class="label-row"><span class="dim-name">'+d.name+'</span><span class="dim-score" style="color:'+lv.color+'">'+Math.round(d.pct)+'%</span></div>'+
        '<div class="bar-track"><div class="bar-fill" data-width="'+d.pct+'" style="background:'+lv.color+'"></div></div></div>';
    });
    document.getElementById('dimBars').innerHTML=barsHtml;

    const sorted=[...dimScores].sort((a,b)=>a.pct-b.pct);
    const priorityDims=['Demand Planning','Inventory Management','Supplier Management','Warehouse Efficiency','Logistics Performance','Technology Integration','Risk & Resilience','Metrics & Governance'];
    const priorityActions=[
      'Implement a structured S&OP process and track forecast accuracy weekly',
      'Define an inventory policy with ABC classification and safety stock optimisation',
      'Establish supplier scorecards and a development programme for critical suppliers',
      'Redesign warehouse layout for flow efficiency and implement slotting reviews',
      'Start tracking OTIF and implement route optimisation for deliveries',
      'Deploy WMS and establish EDI with key suppliers for real-time visibility',
      'Create contingency plans and dual-source critical materials',
      'Set up SC KPI dashboards with a cross-functional review cadence'
    ];

    let priorityHtml='';
    sorted.slice(0,3).forEach((d,i)=>{
      const dimIdx=priorityDims.indexOf(d.name);
      priorityHtml+='<li><strong>'+d.name+' ('+Math.round(d.pct)+'%)</strong> — '+priorityActions[dimIdx]+'</li>';
    });
    document.getElementById('priorityList').innerHTML=priorityHtml;

    setTimeout(()=>{
      document.querySelectorAll('.bar-fill').forEach(b=>{b.style.width=b.dataset.width+'%';});
    },100);

    document.getElementById('results').scrollIntoView({behavior:'smooth'});
  }

  showStep(0);

  document.querySelectorAll('.tool-check-group').forEach(group=>{
    group.querySelectorAll('label').forEach(lbl=>{
      lbl.addEventListener('click',function(){
        group.querySelectorAll('label').forEach(l=>l.classList.remove('selected'));
        this.classList.add('selected');
      });
    });
  });
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
