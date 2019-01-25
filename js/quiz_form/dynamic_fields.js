'use strict';

let state = {
    'qst': 1,
    'ans': [1]
}

let createRep = (q_id, r_id) => {
    let parent = document.createElement('div');
    parent.classList.add('form-row');
    parent.classList.add('col-md-12');

    let bdContainer = document.createElement('div');
    bdContainer.classList.add('form-group');
    bdContainer.classList.add('col-md-5');

    let bd = document.createElement('input');
    bd.setAttribute('type', 'text');
    bd.classList.add('form-control');
    bd.id = 'qcm-qst' + String(q_id) + '-ans' + String(r_id) + '-body';
    bd.setAttribute('placeholder', 'Réponse');
    bd.setAttribute('name', 'qst' + String(q_id) + '-ans' + String(r_id) + '-body');

    bdContainer.appendChild(bd);
    parent.appendChild(bdContainer);

    let scContainer = document.createElement('div');
    scContainer.classList.add('form-group');
    scContainer.classList.add('col-md-5');

    let sc = document.createElement('input');
    sc.setAttribute('type', 'number');
    sc.classList.add('form-control');
    sc.id = 'qcm-qst' + String(q_id) + '-ans' + String(r_id) + '-score';
    sc.setAttribute('placeholder', 'Score');
    sc.setAttribute('name', 'qst' + String(q_id) + '-ans' + String(r_id) + '-score');
    
    scContainer.appendChild(sc);
    parent.appendChild(scContainer);

    let btn = document.createElement('div');
    btn.classList.add('col-md-1');
    btn.classList.add('form-group');
    let link = document.createElement('a');
    link.classList.add('qst' + String(q_id) + '-add-answer');
    link.setAttribute('href', '#');
    link.addEventListener('click', (e) => {
        let qst = document.getElementById(String(q_id));
        qst.appendChild(createRep(q_id, ++state.ans[q_id - 1]));
        let ctr = document.getElementById('qst' + String(q_id) + '-count');
        ctr.value++;
    });
    let icon = document.createElement('i');
    icon.classList.add('fa');
    icon.classList.add('fa-plus');
    link.appendChild(icon);
    btn.appendChild(link);

    parent.appendChild(btn);
    
    return parent;
};

let createQst = (id) => {
    let parent = document.createElement('div');
    parent.classList.add("qst");
    parent.id = String(id);
    let common = document.createElement('div');
    common.classList.add('form-group');
    let row = document.createElement('div');
    row.classList.add('row');
    
    let qsts = document.createElement('div');
    qsts.classList.add('col-md');
    qsts.innerHTML = 'Question ' + String(id);
    row.appendChild(qsts);

    let counter = document.createElement('div');
    let inputTag = document.createElement('input');
    inputTag.setAttribute('type', 'number');
    inputTag.setAttribute('name', 'qst' + String(id) + '-count');
    inputTag.id = 'qst' + String(id) + '-count';
    inputTag.setAttribute('value', 1);
    counter.style.visibility = 'hidden';
    counter.appendChild(inputTag);
    row.appendChild(counter);


    let btn = document.createElement('div');
    btn.classList.add('col-md-1');
    let link = document.createElement('a');
    link.classList.add('add-question');
    link.setAttribute('href', '#');
    link.addEventListener('click', (e) => {
        let questions = document.getElementById('questions');
        questions.appendChild(createQst( ++(state.qst) ));
        state.ans.push(1);
        let ctr = document.getElementById('question-count');
        ctr.value++;
    });
    let icon = document.createElement('i');
    icon.classList.add('fa');
    icon.classList.add('fa-plus');
    link.appendChild(icon);
    btn.appendChild(link);

    row.appendChild(btn);
    common.appendChild(row);

    let bd = document.createElement('textarea');
    bd.setAttribute('cols', '40');
    bd.setAttribute('rows', '5');
    bd.setAttribute('placeholder', 'Texte de la question');
    bd.setAttribute('name', 'qst' + String(id) + '-body');
    bd.required = true;
    bd.classList.add('form-control');
    bd.id = 'qcm-qst' + String(id) + '-body';
    common.appendChild(bd);

    let score = document.createElement('input');
    score.setAttribute('type', 'number');
    score.setAttribute('placeholder', 'Score maximum');
    score.setAttribute('name', 'qst' + String(id) + '-max-score');
    score.required = true;
    score.classList.add('form-control');
    score.id = 'qcm-qst' + String(id) + '-max-score';
    common.appendChild(score);
    parent.appendChild(common);

    let rep = createRep(id, 1);
    parent.appendChild(rep);
    return parent;
};

window.addEventListener('load', (e) => {
    let btns = document.getElementsByClassName('add-question');
    for (let btn of btns){
        btn.addEventListener('click', (e) => {
            let questions = document.getElementById('questions');
            questions.appendChild(createQst( ++(state.qst) ));
            state.ans.push(1);
            let ctr = document.getElementById('question-count');
            ctr.value++;
        });
    }

    let aBtns = document.getElementsByClassName('qst1-add-answer');
    for (let btn of aBtns){
        btn.addEventListener('click', (e) => {
            let qst = document.getElementById('1');
            qst.appendChild(createRep(1, ++state.ans[0]));
            let ctr = document.getElementById('qst1-count');
        ctr.value++;
        });
    }
});


