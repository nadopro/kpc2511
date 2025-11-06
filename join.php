<?php
// join.php
// 전제: index.php에서 이미 <head>와 부트스트랩, material-icons 등이 로드됨
?>
<div class="container my-4" style="max-width: 640px;">
  <h4 class="mb-3">회원가입</h4>

  <form id="joinForm" method="post" action="/?cmd=joinSave" autocomplete="off">
    <!-- 아이디 -->
    <div class="mb-3">
      <label for="user_id" class="form-label">아이디</label>
      <input type="text" class="form-control" id="user_id" name="id" placeholder="아이디(영문/숫자 조합 권장)" required>
      <div id="id_msg" class="form-text"></div>
    </div>

    <!-- 이름 -->
    <div class="mb-3">
      <label for="user_name" class="form-label">이름</label>
      <input type="text" class="form-control" id="user_name" name="name" placeholder="이름을 입력하세요" required>
    </div>

    <!-- 비밀번호 -->
    <div class="mb-3">
      <label for="user_pw" class="form-label">비밀번호</label>
      <input type="password" class="form-control" id="user_pw" name="pass" placeholder="비밀번호" required>
    </div>

    <!-- 비밀번호 확인 -->
    <div class="mb-3">
      <label for="user_pw2" class="form-label">비밀번호 확인</label>
      <input type="password" class="form-control" id="user_pw2" name="pass2" placeholder="비밀번호 확인" required>
      <div id="pw_msg" class="form-text"></div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary" id="submit_btn">가입하기</button>
      <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
    </div>
  </form>
</div>

<script>
// 간단 디바운스
function debounce(fn, wait){
  let t; return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), wait); };
}

(function(){
  const idInput   = document.getElementById('user_id');
  const idMsg     = document.getElementById('id_msg');
  const pw1       = document.getElementById('user_pw');
  const pw2       = document.getElementById('user_pw2');
  const pwMsg     = document.getElementById('pw_msg');
  const submitBtn = document.getElementById('submit_btn');

  let idOk = false;
  let pwOk = false;

  function setMsg(el, text, cls){
    el.className = 'form-text ' + cls;
    el.textContent = text;
  }

  // 아이디 검사
  const checkId = debounce(async function(){
    const val = idInput.value.trim();

    // 4글자 미만
    if (val.length < 4) {
      idOk = false;
      setMsg(idMsg, '4글자 이상만 가능합니다.', 'text-primary');
      return;
    }

    try {
      const res = await fetch('/ajaxCheckId.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
        body: JSON.stringify({ id: val })
      });
      const data = await res.json();

      if (data && data.code === 'ok') {
        idOk = true;
        setMsg(idMsg, data.message || '사용가능한 아이디입니다.', 'text-success');
      } else if (data && data.code === 'short') {
        idOk = false;
        setMsg(idMsg, data.message || '4글자 이상만 가능합니다.', 'text-primary');
      } else {
        idOk = false;
        setMsg(idMsg, (data && data.message) || '사용중인 아이디입니다.', 'text-danger');
      }
    } catch (e) {
      idOk = false;
      setMsg(idMsg, '아이디 확인 중 오류가 발생했습니다.', 'text-danger');
      console.error(e);
    }
  }, 250);

  idInput.addEventListener('keyup', checkId);
  idInput.addEventListener('change', checkId);

  // 비밀번호 일치 검사 (선택)
  function checkPwMatch(){
    const a = pw1.value;
    const b = pw2.value;
    if (!a && !b) {
      pwOk = false;
      setMsg(pwMsg, '', '');
      return;
    }
    if (a === b) {
      pwOk = true;
      setMsg(pwMsg, '비밀번호가 일치합니다.', 'text-success');
    } else {
      pwOk = false;
      setMsg(pwMsg, '비밀번호가 일치하지 않습니다.', 'text-danger');
    }
  }
  pw1.addEventListener('keyup', checkPwMatch);
  pw2.addEventListener('keyup', checkPwMatch);
  pw1.addEventListener('change', checkPwMatch);
  pw2.addEventListener('change', checkPwMatch);

  // 제출 전 간단 검증
  document.getElementById('joinForm').addEventListener('submit', function(e){
    if (!idOk) {
      e.preventDefault();
      idInput.focus();
      return alert('아이디를 확인해 주세요.');
    }
    if (!pwOk) {
      e.preventDefault();
      pw2.focus();
      return alert('비밀번호 확인이 일치해야 합니다.');
    }
  });
})();
</script>
