<?php
// editor.php — execCommand 기본 동작 확인용 간단 예제
?>
<div class="container mt-4">
  <h4>간단한 WYSIWYG 에디터</h4>

  <!-- 툴바 -->
  <div class="mb-2">
    <button type="btn btn-primary" onclick="execCmd('bold')">
      <span class="material-icons">format_bold</span>
    </button>
    <button type="btn btn-primary" onclick="execCmd('underline')">
      <span class="material-icons">format_underlined</span>
    </button>
    <button type="btn btn-primary" onclick="execCmd('italic')">
      <span class="material-icons">format_italic</span>
    </button>
  </div>

  <!-- 에디터 영역 -->
  <div id="editor" contenteditable="true" 
       style="border:1px solid #ccc; min-height:250px; padding:10px;">
    여기에 글을 입력하세요...
  </div>

  <!-- 출력 버튼 -->
  <div class="mt-3">
    <button onclick="showHTML()" class="btn btn-primary">HTML 보기</button>
  </div>

  <!-- 출력 영역 -->
  <pre id="output" style="margin-top:15px; background:#f8f9fa; padding:10px;"></pre>
</div>

<script>
function execCmd(command) {
  document.execCommand(command, false, null);
}

function showHTML() {
  const html = document.getElementById('editor').innerHTML;
  document.getElementById('output').textContent = html;
}
</script>
