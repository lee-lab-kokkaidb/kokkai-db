		function popitup(url) {
			newwindow=window.open(url);
			if (window.focus) {newwindow.focus()}
			return false;
		}

		function change_order(id){
			disp_executing();
			if(id == document.page.order.value){
				document.page.direction.value = document.page.direction.value == "ASC" ? "DESC" : "ASC";  
			}else{
				document.page.order.value = id;
				document.page.direction.value = "ASC";
			}
			document.page.page.value = 1;
			document.page.submit();
		}
		
		function change_page(page){
			disp_executing();
			document.page.page.value = page;
			document.page.submit();
		}

		function disp_executing(){
			
			window.scrollTo(0, 0);

			var wait = document.createElement("div");
			with(wait.style){
				textAlign = "center";
				backgroundColor = "#000";
				filter = "alpha(opacity=80)";
				position = "absolute";
				left = "0px";
				top = "0px";
				cursor = "wait";
				width = "100%";
				zIndex = 1000;
				opacity = 0.80;
				height = Math.max(document.body.clientHeight, document.documentElement.clientHeight) + "px";
			}
		    var op = document.createElement("p");
			with(op.style){
				position = "absolute";
				top = (Math.min(document.body.clientHeight, document.documentElement.clientHeight)  / 2 -50) + "px";
				left = 0;
				color = "#fff";
				width = "100%";
			}
			op.innerHTML = "処理中です。しばらくお待ちください。<br><br>";
		    op.appendChild(oImgWait);
		    wait.appendChild(op);
			document.body.appendChild(wait);

		}
	    var oImgWait = document.createElement('img');
	    oImgWait.setAttribute("src", "images/progress.gif");
