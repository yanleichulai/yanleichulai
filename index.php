<!DOCTYPE html>
<html>
<head><meta name="generator" content="Hexo 3.9.0">
  <meta charset="utf-8">
  

  
  <title>Hexo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta property="og:type" content="website">
<meta property="og:title" content="Hexo">
<meta property="og:url" content="http://yoursite.com/index.html">
<meta property="og:site_name" content="Hexo">
<meta property="og:locale" content="en">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Hexo">
  
    <link rel="alternate" href="/atom.xml" title="Hexo" type="application/atom+xml">
  
  
    <link rel="icon" href="/favicon.png">
  
  
    <link href="//fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet" type="text/css">
  
  <link rel="stylesheet" href="/css/style.css">
</head>
</html>
<body>
  <div id="container">
    <div id="wrap">
      <header id="header">
  <div id="banner"></div>
  <div id="header-outer" class="outer">
    <div id="header-title" class="inner">
      <h1 id="logo-wrap">
        <a href="/" id="logo">Hexo</a>
      </h1>
      
    </div>
    <div id="header-inner" class="inner">
      <nav id="main-nav">
        <a id="main-nav-toggle" class="nav-icon"></a>
        
          <a class="main-nav-link" href="/">Home</a>
        
          <a class="main-nav-link" href="/archives">Archives</a>
        
      </nav>
      <nav id="sub-nav">
        
          <a id="nav-rss-link" class="nav-icon" href="/atom.xml" title="RSS Feed"></a>
        
        <a id="nav-search-btn" class="nav-icon" title="Search"></a>
      </nav>
      <div id="search-form-wrap">
        <form action="//google.com/search" method="get" accept-charset="UTF-8" class="search-form"><input type="search" name="q" class="search-form-input" placeholder="Search"><button type="submit" class="search-form-submit">&#xF002;</button><input type="hidden" name="sitesearch" value="http://yoursite.com"></form>
      </div>
    </div>
  </div>
</header>
      <div class="outer">
        <section id="main">
  
    <article id="post-06.贪吃蛇-面向对象" class="article article-type-post" itemscope itemprop="blogPost">
  <div class="article-meta">
    <a href="/2019/09/16/06.贪吃蛇-面向对象/" class="article-date">
  <time datetime="2019-09-16T08:37:37.823Z" itemprop="datePublished">2019-09-16</time>
</a>
    
  </div>
  <div class="article-inner">
    
    
    <div class="article-entry" itemprop="articleBody">
      
        <!DOCTYPE html>
<html lang="en">
<head><meta name="generator" content="Hexo 3.9.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        #map {
            width: 800px;
            height: 600px;
            background-color: #ccc;
            position: relative;
        }
    </style>
</head>
<body>
    <div id="map">

    </div>
</body>

<script>
    ;(function(w){
        function Random(){
        }
        //写一个方法 获取指定范围的随机数
        Random.prototype.getRandom = function(min,max){
            return Math.floor(Math.random()*(max-min)+min) ;
        }
        w.Random = Random;
    })(window)




    ;(function(w){
        //存放页面上的食物dom对象的数组
        var elements = [];

        function Food(){
            //位置
            this.x = 20;
            this.y = 20;
            //颜色
            this.color = "green";
            //宽高
            this.width = 20;
            this.height = 20;
        }

        //随机生成食物的x和y的坐标
        Food.prototype.random = function(map){
            //得到地图的宽高
            var mapWidth = map.offsetWidth;  //获取的是边框以及边框以内的宽度
            var mapHeight = map.offsetHeight;  
            
            var random = new Random();
            var x = random.getRandom(0,mapWidth/this.width);
            var y = random.getRandom(0,mapHeight/this.height);

            //更改当前食物对象的x和y坐标
            this.x = x;
            this.y = y;
        }

        //init方法的作用：根据当前的Food对象，创建dom对象显示到页面
        Food.prototype.init = function(map){
            //移除之前的食物
            remove();

            //调用random方法来获取食物的随机位置
            this.random(map);

            //创建dom对象，把dom对象添加到页面中
            var div = document.createElement("div");
            div.style.width = this.width+"px";
            div.style.height = this.height+"px";
            div.style.position = "absolute";
            div.style.left = this.x*this.width + "px";
            div.style.top = this.y*this.height + "px";
            div.style.backgroundColor = this.color;
            map.appendChild(div);

            //把当前食物添加到elements数组
            elements.push(div);
        }

        //移除页面上之前食物的方法
        function remove(){
            for(var i=0;i<elements.length;i++){
                var ele = elements[i];
                //从数组中第i个位置开始删除一个元素
                elements.splice(i,1);
                //从页面删除该元素
                ele.parentNode.removeChild(ele);
            }
        }

        //把Food挂载到window对象中，目的是为了在自调用函数外部使用Food
        w.Food = Food;
    })(window)



    ;(function(w){
        //存放页面小蛇身躯的数组
        var elements = [];

        function Snake(){
            this.width = 20;
            this.height = 20;
            this.direction = "right";
            this.body = [
                {
                    x:3,
                    y:2,
                    color:"red"
                },
                {
                    x:2,
                    y:2,
                    color:"pink"
                },
                {
                    x:1,
                    y:2,
                    color:"pink"
                }
            ]
        }

        //小蛇的初始化方法：作用是把蛇显示在地图上
        Snake.prototype.init = function(map){
            //每一次初始化小蛇的时候先移除之前的小蛇
            remove();

            //1.遍历小蛇的每一个身躯
            for(var i=0;i<this.body.length;i++){
                //2.拿到小蛇的每一个身躯
                var b = this.body[i];
                //3.小蛇有多少个身躯就创建多少个div
                var div = document.createElement("div");
                div.style.width = this.width+"px";
                div.style.height = this.height+"px";
                div.style.position = "absolute";
                div.style.left = b.x*this.width+ "px";
                div.style.top = b.y*this.height + "px";
                div.style.backgroundColor = b.color;
                //4.把每一个小蛇身躯的div显示在页面上
                map.appendChild(div);
                //5.把每一个小蛇的身躯加到elements数组里面
                elements.push(div)
            }
        }

        //小蛇移动的方法
        Snake.prototype.move = function(){
            for(var i=this.body.length-1;i>0;i--){
                this.body[i].x = this.body[i-1].x;
                this.body[i].y = this.body[i-1].y;
            }
            switch (this.direction) {
                case "right":
                    this.body[0].x += 1;
                    break;
                case "left":
                    this.body[0].x -= 1;
                    break;
                case "up":
                    this.body[0].y -= 1;
                    break;
                case "down":
                    this.body[0].y += 1;
                    break;
                default:
                    break;
            }
        }


        //小蛇吃食物的方法
        Snake.prototype.eat = function(food,map){
            //1.获取食物坐标
            var foodX = food.x;
            var foodY = food.y;
            //2.获取蛇头的坐标
            var headX = this.body[0].x;
            var headY = this.body[0].y;

            //3.当蛇头坐标和食物坐标完全重叠的时候，说明小蛇要吃食物了
            if(foodX == headX && foodY == headY){
                //重新初始化一个食物
                food.init(map);
                //让小蛇的身躯+1  只要把小蛇身躯的最后一个部分复制一份重新追加到小蛇的body数组里面就可以了
                this.body.push({
                    x:this.body[this.body.length-1].x,
                    y:this.body[this.body.length-1].y,
                    color:this.body[this.body.length-1].color,
                })
            }
        }

        //移除小蛇的方法
        function remove(){
            //如果要一边遍历数组，一边删除数组元素，一定要从数组的尾巴开始遍历
            for(var i=elements.length-1;i>=0;i--){
                var ele = elements[i];
                elements.splice(i,1);
                ele.parentNode.removeChild(ele);
            }
        }
        w.Snake = Snake;
    })(window)




    ;(function(w){
        function Game(food,snake){
            this.food = new Food();
            this.snake = new Snake();
            this.map = document.getElementById("map");
        }


        //开始游戏的方法
        Game.prototype.startGame = function(){
            //让食物显示在页面
            this.food.init(this.map)


            //把蛇显示在页面上
            //谁调用startGame函数，this就是谁
            var that = this;
            //定时器中的this 是window
            var timer = setInterval(function(){
                that.snake.init(that.map);
                that.snake.move(); 
                that.snake.eat(that.food,that.map);
                that.gameOver(timer);
            }, 200);
        }

        //绑定键盘事件的方法
        Game.prototype.bindKey = function(){
            var that = this;
            document.onkeydown = function(e){
                if(e.keyCode == 37){
                    if(that.snake.direction == "left" || that.snake.direction == "right"){
                        return;
                    }
                    //左
                    that.snake.direction = "left";
                }
                else if(e.keyCode == 38){
                    if(that.snake.direction == "up" || that.snake.direction == "down"){
                        return;
                    }
                    //上
                    that.snake.direction = "up";
                }
                else if(e.keyCode == 39){
                    if(that.snake.direction == "left" || that.snake.direction == "right"){
                        return;
                    }
                    //右
                    that.snake.direction = "right";
                }
                else{
                    if(that.snake.direction == "up" || that.snake.direction == "down"){
                        return;
                    }
                    //下
                    that.snake.direction = "down";
                }
            }
        }

        Game.prototype.gameOver = function(timer){
            //条件 小蛇出界了  或者小蛇蛇头撞到身躯了 
            var mapWidth = this.map.offsetWidth;
            var mapHeight = this.map.offsetHeight;
            var maxX = mapWidth/this.snake.width;
            var maxH = mapHeight/this.snake.height;

            //获取蛇头
            var head = this.snake.body[0];
            if(head.x <0 || head.x >=maxX || head.y<0 ||head.y>=maxH){
                clearInterval(timer);
                alert("游戏结束")
            }
            //看蛇头有没有碰到身躯，碰到身躯游戏结束
            for(var i=1;i<this.snake.body.length;i++){
                var b = this.snake.body[i];
                if(head.x == b.x && head.y == b.y){
                    clearInterval(timer);
                    alert("游戏结束")
                    break;
                }
            }
        }

        w.Game = Game;
    })(window)



    //创建一个游戏对象，入参食物对象和蛇对象
    var game = new Game();
    game.bindKey();
    game.startGame();
</script>

</html>
      
    </div>
    <footer class="article-footer">
      <a data-url="http://yoursite.com/2019/09/16/06.贪吃蛇-面向对象/" data-id="ck0m5ojln00009cwlyp9e451z" class="article-share-link">Share</a>
      
      
    </footer>
  </div>
  
</article>


  
    <article id="post-小晖晖的第一篇博客" class="article article-type-post" itemscope itemprop="blogPost">
  <div class="article-meta">
    <a href="/2019/09/11/小晖晖的第一篇博客/" class="article-date">
  <time datetime="2019-09-11T03:28:47.000Z" itemprop="datePublished">2019-09-11</time>
</a>
    
  </div>
  <div class="article-inner">
    
    
      <header class="article-header">
        
  
    <h1 itemprop="name">
      <a class="article-title" href="/2019/09/11/小晖晖的第一篇博客/">小晖晖的第一篇博客</a>
    </h1>
  

      </header>
    
    <div class="article-entry" itemprop="articleBody">
      
        
      
    </div>
    <footer class="article-footer">
      <a data-url="http://yoursite.com/2019/09/11/小晖晖的第一篇博客/" data-id="ck0m5mvmm0000acwlp10r2d94" class="article-share-link">Share</a>
      
      
    </footer>
  </div>
  
</article>


  
    <article id="post-hello-world" class="article article-type-post" itemscope itemprop="blogPost">
  <div class="article-meta">
    <a href="/2019/09/11/hello-world/" class="article-date">
  <time datetime="2019-09-11T03:25:55.153Z" itemprop="datePublished">2019-09-11</time>
</a>
    
  </div>
  <div class="article-inner">
    
    
      <header class="article-header">
        
  
    <h1 itemprop="name">
      <a class="article-title" href="/2019/09/11/hello-world/">Hello World</a>
    </h1>
  

      </header>
    
    <div class="article-entry" itemprop="articleBody">
      
        <p>Welcome to <a href="https://hexo.io/" target="_blank" rel="noopener">Hexo</a>! This is your very first post. Check <a href="https://hexo.io/docs/" target="_blank" rel="noopener">documentation</a> for more info. If you get any problems when using Hexo, you can find the answer in <a href="https://hexo.io/docs/troubleshooting.html" target="_blank" rel="noopener">troubleshooting</a> or you can ask me on <a href="https://github.com/hexojs/hexo/issues" target="_blank" rel="noopener">GitHub</a>.</p>
<h2 id="Quick-Start"><a href="#Quick-Start" class="headerlink" title="Quick Start"></a>Quick Start</h2><h3 id="Create-a-new-post"><a href="#Create-a-new-post" class="headerlink" title="Create a new post"></a>Create a new post</h3><figure class="highlight bash"><table><tr><td class="gutter"><pre><span class="line">1</span><br></pre></td><td class="code"><pre><span class="line">$ hexo new <span class="string">"My New Post"</span></span><br></pre></td></tr></table></figure>

<p>More info: <a href="https://hexo.io/docs/writing.html" target="_blank" rel="noopener">Writing</a></p>
<h3 id="Run-server"><a href="#Run-server" class="headerlink" title="Run server"></a>Run server</h3><figure class="highlight bash"><table><tr><td class="gutter"><pre><span class="line">1</span><br></pre></td><td class="code"><pre><span class="line">$ hexo server</span><br></pre></td></tr></table></figure>

<p>More info: <a href="https://hexo.io/docs/server.html" target="_blank" rel="noopener">Server</a></p>
<h3 id="Generate-static-files"><a href="#Generate-static-files" class="headerlink" title="Generate static files"></a>Generate static files</h3><figure class="highlight bash"><table><tr><td class="gutter"><pre><span class="line">1</span><br></pre></td><td class="code"><pre><span class="line">$ hexo generate</span><br></pre></td></tr></table></figure>

<p>More info: <a href="https://hexo.io/docs/generating.html" target="_blank" rel="noopener">Generating</a></p>
<h3 id="Deploy-to-remote-sites"><a href="#Deploy-to-remote-sites" class="headerlink" title="Deploy to remote sites"></a>Deploy to remote sites</h3><figure class="highlight bash"><table><tr><td class="gutter"><pre><span class="line">1</span><br></pre></td><td class="code"><pre><span class="line">$ hexo deploy</span><br></pre></td></tr></table></figure>

<p>More info: <a href="https://hexo.io/docs/deployment.html" target="_blank" rel="noopener">Deployment</a></p>

      
    </div>
    <footer class="article-footer">
      <a data-url="http://yoursite.com/2019/09/11/hello-world/" data-id="ck0m5mvmt0001acwlxaz05r8k" class="article-share-link">Share</a>
      
      
    </footer>
  </div>
  
</article>


  


</section>
        
          <aside id="sidebar">
  
    

  
    

  
    
  
    
  <div class="widget-wrap">
    <h3 class="widget-title">Archives</h3>
    <div class="widget">
      <ul class="archive-list"><li class="archive-list-item"><a class="archive-list-link" href="/archives/2019/09/">September 2019</a></li></ul>
    </div>
  </div>


  
    
  <div class="widget-wrap">
    <h3 class="widget-title">Recent Posts</h3>
    <div class="widget">
      <ul>
        
          <li>
            <a href="/2019/09/16/06.贪吃蛇-面向对象/">(no title)</a>
          </li>
        
          <li>
            <a href="/2019/09/11/小晖晖的第一篇博客/">小晖晖的第一篇博客</a>
          </li>
        
          <li>
            <a href="/2019/09/11/hello-world/">Hello World</a>
          </li>
        
      </ul>
    </div>
  </div>

  
</aside>
        
      </div>
      <footer id="footer">
  
  <div class="outer">
    <div id="footer-info" class="inner">
      &copy; 2019 John Doe<br>
      Powered by <a href="http://hexo.io/" target="_blank">Hexo</a>
    </div>
  </div>
</footer>
    </div>
    <nav id="mobile-nav">
  
    <a href="/" class="mobile-nav-link">Home</a>
  
    <a href="/archives" class="mobile-nav-link">Archives</a>
  
</nav>
    

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>


  <link rel="stylesheet" href="/fancybox/jquery.fancybox.css">
  <script src="/fancybox/jquery.fancybox.pack.js"></script>


<script src="/js/script.js"></script>



  </div>
</body>
</html>