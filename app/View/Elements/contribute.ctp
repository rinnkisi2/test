<!-- 貢献度 -->
貢献度リストのテスト
<?php #echo $count; ?>

		<!-- <p>過去の受験日</p>
		<p>過去の問題</p>
		<p>合格者推移</p>

		<p>会場</p>
		<p>募集時期</p>
		<p>値段</p>

		<p>受検者数</p>
		<p>受検者出身</p>
		<p>受検者年代</p>
		<p>受検者職業</p>

		<p>収入</p> -->
<div id="bar-demo"></div>
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
	(function() {
//棒グラフとして表示するデータ（Y軸=books)
var data = [{year: 'suto', books: 54},
            {year: '真山', books: 43},
            {year: 'n0bisuke', books: 41},
            {year: 'alala', books: 44},
            {year: 'yoneya', books: 35} 
	   ];

var barWidth = 40;
var width = (barWidth + 10) * data.length;
var height = 200;

/*
  domain() データの最小値と最大値を設定
  reange() データをpixcelにマッピングする際のレンジ
　例)
　var xScale = d3.scale.linear().domain([0, 20]).range([0, 100]);
  xScale(0)	=> 0
  xScals(10)	=> 50
  xScale(20)	=> 100
*/    
var x = d3.scale.linear().domain([0, data.length]).range([0, width]);
var y = d3.scale.linear().domain([0, d3.max(data, function(datum) { return datum.books; })]).
  rangeRound([0, height]);

    
    
// グラフを表示するsvgエリアを作成
var barDemo = d3.select("#bar-demo").
  append("svg:svg").
  attr("width", width).
  attr("height", height+20); //年代を表示するために20pxを足している

    
    
//棒グラフの表示    
barDemo.selectAll("rect").
  data(data).
  enter().
  append("svg:rect").

  attr("x", function(datum, index) { return x(index); }).
  attr("y", function(datum) { return height - y(datum.books); }).
  attr("height", function(datum) { return y(datum.books); }).
  attr("width", barWidth).
  attr("fill", "#2d578b").
  //棒グラフにイベントを設置
  on("mouseover", function(){d3.select(this).style("fill", "blue");}).
  on("mouseout", function(){d3.select(this).style("fill", "#2d578b");});
    
    
//数値(books)を表示    
barDemo.selectAll("text").
  data(data).
  enter().
  append("svg:text").
  attr("x", function(datum, index) { return x(index) + barWidth; }).
  attr("y", function(datum) { return height - y(datum.books); }).
  attr("dx", -barWidth/2).
  attr("dy", "1.2em").
  attr("text-anchor", "middle").
  text(function(datum) { return datum.books;}).
  attr("fill", "white");

    
//年代(year)を表示    
barDemo.selectAll("text.yAxis").
  data(data).
  enter().append("svg:text").
  attr("x", function(datum, index) { return x(index) + barWidth; }).
  attr("y", height).
  attr("dx", -barWidth/2).
  attr("text-anchor", "middle").
  attr("style", "font-size: 12; font-family: Helvetica, sans-serif").
  text(function(datum) { return datum.year;}).
  attr("transform", "translate(0, 18)").
  attr("class", "yAxis");
    
    
})();

</script>