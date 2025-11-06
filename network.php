<?php
// network.php
// 전제: index.php에서 <head> 등 기본 헤더가 구성되어 있음.
// D3가 없다면 아래 CDN 스크립트가 로드됩니다(중복 로드 안전).
?>
<div id="netwrap" style="width:100%; max-width:1000px; margin:0 auto;">
  <svg id="networkSvg" viewBox="0 0 1000 600" style="width:100%; height:auto; border:1px solid #e5e5e5; background:#fff;"></svg>
</div>

<script>
// D3 v7 로드 (이미 로드된 경우 재로딩 없이 사용)
(function ensureD3(cb){
  if (window.d3) return cb();
  var s = document.createElement('script');
  s.src = 'https://cdn.jsdelivr.net/npm/d3@7';
  s.onload = cb;
  document.head.appendChild(s);
})(function initNetwork(){

  // ===== 데이터: nodes & links =====
  const graph = {
    nodes: [
      { id: "홍길동" },
      { id: "홍대감" },
      { id: "이이" },
      { id: "사임당" },
      { id: "정약용" },
      { id: "정약전" }
    ],
    links: [
      { source: "홍대감", target: "홍길동", relation: "아들" },
      { source: "홍길동", target: "이이", relation: "친구" },
      { source: "사임당", target: "이이", relation: "아들" },
      { source: "정약용", target: "정약전", relation: "형제" },
      { source: "정약전", target: "정약용", relation: "형제" },
      { source: "정약용", target: "홍길동", relation: "친구" }
    ]
  };

  // ===== SVG 및 루트 그룹 =====
  const svg = d3.select('#networkSvg');
  const root = svg.append('g');     // 줌/팬의 대상이 되는 루트 그룹

  // ===== 줌/팬 설정 =====
  const zoom = d3.zoom()
    .scaleExtent([0.2, 3])          // 최소/최대 확대 비율
    .on('zoom', (event) => {
      root.attr('transform', event.transform);
    });
  svg.call(zoom).on('dblclick.zoom', null); // 더블클릭 줌 비활성(원하면 제거)

  // ===== 링크, 노드 그룹 =====
  const linkGroup = root.append('g').attr('class', 'links');
  const nodeGroup = root.append('g').attr('class', 'nodes');
  const labelGroup = root.append('g').attr('class', 'labels'); // 노드 라벨

  // ===== 시뮬레이션(Force) 설정 =====
  const simulation = d3.forceSimulation(graph.nodes)
    .force('link', d3.forceLink(graph.links).id(d => d.id).distance(140).strength(0.6))
    .force('charge', d3.forceManyBody().strength(-420))
    .force('center', d3.forceCenter(500, 300)) // viewBox 기준 중앙(1000x600)
    .force('collide', d3.forceCollide(36));

  // ===== 링크 그리기 =====
  const link = linkGroup.selectAll('line')
    .data(graph.links)
    .enter()
    .append('line')
    .attr('stroke', '#b9c0d0')
    .attr('stroke-width', 2)
    .attr('marker-end', 'url(#arrow)')   // 화살표 (친구/형제는 방향성 없어도 시각적으로 도움)
    .append('title')
    .text(d => `${d.source.id || d.source} → ${d.target.id || d.target} (${d.relation})`);

  // 화살표 마커 정의
  const defs = svg.append('defs');
  defs.append('marker')
    .attr('id', 'arrow')
    .attr('viewBox', '0 0 10 10')
    .attr('refX', 16) // 노드 반지름+여유
    .attr('refY', 5)
    .attr('markerWidth', 6)
    .attr('markerHeight', 6)
    .attr('orient', 'auto-start-reverse')
    .append('path')
    .attr('d', 'M 0 0 L 10 5 L 0 10 z')
    .attr('fill', '#b9c0d0');

  // ===== 노드 그리기 (원 + title 툴팁) =====
  const node = nodeGroup.selectAll('circle')
    .data(graph.nodes)
    .enter()
    .append('circle')
    .attr('r', 16)
    .attr('fill', '#3e7aff')
    .attr('stroke', '#1b4fbf')
    .attr('stroke-width', 1.5)
    .call(drag(simulation));

  node.append('title').text(d => d.id);

  // ===== 노드 라벨 =====
  const label = labelGroup.selectAll('text')
    .data(graph.nodes)
    .enter()
    .append('text')
    .attr('font-family', 'system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, Apple SD Gothic Neo, Noto Sans KR, sans-serif')
    .attr('font-size', 14)
    .attr('fill', '#333')
    .attr('text-anchor', 'middle')
    .attr('dy', 32) // 노드 아래쪽에 배치
    .text(d => d.id)
    .style('pointer-events', 'none');

  // ===== 드래그 동작 =====
  function drag(sim){
    function dragstarted(event, d){
      if (!event.active) sim.alphaTarget(0.3).restart();
      d.fx = d.x; d.fy = d.y;
    }
    function dragged(event, d){
      d.fx = event.x; d.fy = event.y;
    }
    function dragended(event, d){
      if (!event.active) sim.alphaTarget(0);
      d.fx = null; d.fy = null;
    }
    return d3.drag()
      .on('start', dragstarted)
      .on('drag', dragged)
      .on('end', dragended);
  }

  // ===== 시뮬레이션 틱마다 위치 업데이트 =====
  simulation.on('tick', () => {
    linkGroup.selectAll('line')
      .attr('x1', d => d.source.x)
      .attr('y1', d => d.source.y)
      .attr('x2', d => d.target.x)
      .attr('y2', d => d.target.y);

    node.attr('cx', d => d.x).attr('cy', d => d.y);
    label.attr('x', d => d.x).attr('y', d => d.y);
  });

  // ===== 초기 전체 보기로 살짝 맞추는 애니메이션(선택) =====
  // svg.transition().duration(250).call(zoom.transform, d3.zoomIdentity.translate(0,0).scale(1));

});
</script>
