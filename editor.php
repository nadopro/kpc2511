<?php
// editor.php
// WYSIWYG 에디터 예제: 제목, 툴바(Bold/Underline/Italic), 에디터 영역, 글등록 버튼
?>
<div class="container">
  <h4 class="mb-3">글쓰기 (WYSIWYG 에디터 예제)</h4>

  <form id="editorForm" method="post" action="/?cmd=editor&mode=save">
    <!-- 제목 -->
    <div class="mb-3">
      <label class="form-label">제목</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="제목을 입력하세요" required>
    </div>

    <!-- 툴바: Material Icons 사용 -->
    <div class="mb-2 d-flex align-items-center" role="toolbar" aria-label="Text formatting">
      <div class="btn-group me-2" role="group" aria-label="formatting">
        <button type="button" class="btn btn-light btn-sm" data-cmd="bold" title="Bold (Ctrl+B)">
          <span class="material-icons">format_bold</span>
        </button>
        <button type="button" class="btn btn-light btn-sm" data-cmd="underline" title="Underline (Ctrl+U)">
          <span class="material-icons">format_underlined</span>
        </button>
        <button type="button" class="btn btn-light btn-sm" data-cmd="italic" title="Italic (Ctrl+I)">
          <span class="material-icons">format_italic</span>
        </button>
      </div>

      <!-- 글꼴/정렬/색상 등 추가 컨트롤을 넣고 싶다면 이곳에 추가 -->
      <div class="ms-auto text-muted small">간단 예제입니다.</div>
    </div>

    <!-- 에디터 영역 (contenteditable) -->
    <div id="editor" class="border rounded p-3 mb-3" contenteditable="true"
         style="min-height:300px; outline: none; overflow:auto; background:white;">
      <!-- 기본 플레이스홀더 -->
      <div id="editorPlaceholder" style="color:#888;">여기에 내용을 입력하세요. (HTML 형식 저장)</div>
    </div>

    <!-- 숨겨진 textarea: 폼 전송 시 에디터 HTML을 이곳에 넣어 전송 -->
    <textarea name="html" id="html" class="d-none"></textarea>

    <!-- 버튼 -->
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">글등록</button>
      <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
    </div>
  </form>
</div>

<script>
(function(){
  // 툴바 버튼 동작: document.execCommand 사용(레거시지만 간단 실습용)
  // 버튼 클릭 시 포커스 보존 및 명령 실행
  const toolbarButtons = document.querySelectorAll('[data-cmd]');
  toolbarButtons.forEach(btn => {
    btn.addEventListener('click', function(e){
      const cmd = this.getAttribute('data-cmd');
      document.execCommand(cmd, false, null);
      // 버튼 active 표시 토글(간단)
      this.classList.toggle('active');
      // 포커스 에디터로 되돌리기
      document.getElementById('editor').focus();
    });
  });

  // placeholder 처리: 내용이 비어있으면 placeholder 보이기
  const editor = document.getElementById('editor');
  const placeholder = document.getElementById('editorPlaceholder');

  function refreshPlaceholder(){
    // 텍스트 컨텐츠만 검사 (공백만 있으면 비어있음으로 처리)
    const text = editor.textContent.replace(/\u200B/g,'').trim();
    if (text.length === 0 && editor.querySelectorAll('img,iframe,table').length === 0) {
      placeholder.style.display = 'block';
    } else {
      placeholder.style.display = 'none';
    }
  }

  editor.addEventListener('input', refreshPlaceholder);
  editor.addEventListener('focus', refreshPlaceholder);
  editor.addEventListener('blur', refreshPlaceholder);

  // 폼 제출 전 에디터 내용을 숨겨진 textarea에 넣음
  const form = document.getElementById('editorForm');
  form.addEventListener('submit', function(e){
    // 에디터 HTML 취득
    let html = editor.innerHTML;

    // placeholder가 보이는 상태라면 빈값으로 처리
    if (placeholder.style.display !== 'none') {
      html = '';
    }

    // 간단한 서버 전송 전 정리: (원하면 추가로 sanitize 권장)
    document.getElementById('html').value = html;

    // 실제 저장 시 XSS 방지를 위해 서버에서 반드시 입력값을 검증/필터링하세요.
    // (예: 허용 태그 필터링, 이미지 업로드 처리, CSP 설정 등)
    return true; // 폼 전송 계속
  });

  // 단축키: Ctrl+B/Ctrl+I/Ctrl+U 를 브라우저 기본과 동일하게 유지시키기 위해 keydown 처리
  document.addEventListener('keydown', function(e){
    if ((e.ctrlKey || e.metaKey) && !e.shiftKey) {
      const key = e.key.toLowerCase();
      if (key === 'b' || key === 'i' || key === 'u') {
        // execCommand로 처리
        if (key === 'b') document.execCommand('bold');
        if (key === 'i') document.execCommand('italic');
        if (key === 'u') document.execCommand('underline');
        e.preventDefault();
      }
    }
  });

  // 초기 placeholder 상태 설정
  refreshPlaceholder();

})();
</script>

<style>
/* 작은 스타일: 활성 버튼 시 시각적 표시 */
.btn-group .btn.active {
  background-color: #e7f1ff;
  border-color: #bcd8ff;
}
</style>
<?php
// editor.php
// WYSIWYG 에디터 예제: 제목, 툴바(Bold/Underline/Italic), 에디터 영역, 글등록 버튼
?>
<div class="container">
  <h4 class="mb-3">글쓰기 (WYSIWYG 에디터 예제)</h4>

  <form id="editorForm" method="post" action="/?cmd=editor&mode=save">
    <!-- 제목 -->
    <div class="mb-3">
      <label class="form-label">제목</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="제목을 입력하세요" required>
    </div>

    <!-- 툴바: Material Icons 사용 -->
    <div class="mb-2 d-flex align-items-center" role="toolbar" aria-label="Text formatting">
      <div class="btn-group me-2" role="group" aria-label="formatting">
        <button type="button" class="btn btn-light btn-sm" data-cmd="bold" title="Bold (Ctrl+B)">
          <span class="material-icons">format_bold</span>
        </button>
        <button type="button" class="btn btn-light btn-sm" data-cmd="underline" title="Underline (Ctrl+U)">
          <span class="material-icons">format_underlined</span>
        </button>
        <button type="button" class="btn btn-light btn-sm" data-cmd="italic" title="Italic (Ctrl+I)">
          <span class="material-icons">format_italic</span>
        </button>
      </div>

      <!-- 글꼴/정렬/색상 등 추가 컨트롤을 넣고 싶다면 이곳에 추가 -->
      <div class="ms-auto text-muted small">간단 예제입니다.</div>
    </div>

    <!-- 에디터 영역 (contenteditable) -->
    <div id="editor" class="border rounded p-3 mb-3" contenteditable="true"
         style="min-height:300px; outline: none; overflow:auto; background:white;">
      <!-- 기본 플레이스홀더 -->
      <div id="editorPlaceholder" style="color:#888;">여기에 내용을 입력하세요. (HTML 형식 저장)</div>
    </div>

    <!-- 숨겨진 textarea: 폼 전송 시 에디터 HTML을 이곳에 넣어 전송 -->
    <textarea name="html" id="html" class="d-none"></textarea>

    <!-- 버튼 -->
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">글등록</button>
      <a href="/?cmd=init" class="btn btn-outline-secondary">취소</a>
    </div>
  </form>
</div>

<script>
(function(){
  // 툴바 버튼 동작: document.execCommand 사용(레거시지만 간단 실습용)
  // 버튼 클릭 시 포커스 보존 및 명령 실행
  const toolbarButtons = document.querySelectorAll('[data-cmd]');
  toolbarButtons.forEach(btn => {
    btn.addEventListener('click', function(e){
      const cmd = this.getAttribute('data-cmd');
      document.execCommand(cmd, false, null);
      // 버튼 active 표시 토글(간단)
      this.classList.toggle('active');
      // 포커스 에디터로 되돌리기
      document.getElementById('editor').focus();
    });
  });

  // placeholder 처리: 내용이 비어있으면 placeholder 보이기
  const editor = document.getElementById('editor');
  const placeholder = document.getElementById('editorPlaceholder');

  function refreshPlaceholder(){
    // 텍스트 컨텐츠만 검사 (공백만 있으면 비어있음으로 처리)
    const text = editor.textContent.replace(/\u200B/g,'').trim();
    if (text.length === 0 && editor.querySelectorAll('img,iframe,table').length === 0) {
      placeholder.style.display = 'block';
    } else {
      placeholder.style.display = 'none';
    }
  }

  editor.addEventListener('input', refreshPlaceholder);
  editor.addEventListener('focus', refreshPlaceholder);
  editor.addEventListener('blur', refreshPlaceholder);

  // 폼 제출 전 에디터 내용을 숨겨진 textarea에 넣음
  const form = document.getElementById('editorForm');
  form.addEventListener('submit', function(e){
    // 에디터 HTML 취득
    let html = editor.innerHTML;

    // placeholder가 보이는 상태라면 빈값으로 처리
    if (placeholder.style.display !== 'none') {
      html = '';
    }

    // 간단한 서버 전송 전 정리: (원하면 추가로 sanitize 권장)
    document.getElementById('html').value = html;

    // 실제 저장 시 XSS 방지를 위해 서버에서 반드시 입력값을 검증/필터링하세요.
    // (예: 허용 태그 필터링, 이미지 업로드 처리, CSP 설정 등)
    return true; // 폼 전송 계속
  });

  // 단축키: Ctrl+B/Ctrl+I/Ctrl+U 를 브라우저 기본과 동일하게 유지시키기 위해 keydown 처리
  document.addEventListener('keydown', function(e){
    if ((e.ctrlKey || e.metaKey) && !e.shiftKey) {
      const key = e.key.toLowerCase();
      if (key === 'b' || key === 'i' || key === 'u') {
        // execCommand로 처리
        if (key === 'b') document.execCommand('bold');
        if (key === 'i') document.execCommand('italic');
        if (key === 'u') document.execCommand('underline');
        e.preventDefault();
      }
    }
  });

  // 초기 placeholder 상태 설정
  refreshPlaceholder();

})();
</script>

<style>
/* 작은 스타일: 활성 버튼 시 시각적 표시 */
.btn-group .btn.active {
  background-color: #e7f1ff;
  border-color: #bcd8ff;
}
</style>
