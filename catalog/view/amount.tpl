<div class="main-inner">
	<p class="p-title">我的积分</p>
	<?php if(empty($amount)){
		echo '账户还未开通';
	}else{ ?>
		<div class="amount-info">
			<ul class="fix">
				<li>
					<div class="amount-info-inner b-yellow">
						<p>
							<i class="icon iconfont">&#xe629;</i>
						</p>
						<h2>
							您的积分为：<span id="score"><?php echo $amount['score'];?></span>分
						</h2>
					</div>
				</li>
				<li>
					<div class="amount-info-inner b-lightgreen">
						<p>
							<i class="icon iconfont">&#xe668;</i>
						</p>
						<h2>
							您的账户余额为：<span id="money"><?php echo $amount['money'];?></span>￥
						</h2>
					</div>
				</li>
				<li>
					<div class="amount-info-inner b-pink mr0">
						<button class="exchange-btn" onclick="transfer(this);">
							<span class="loading dn" id="loading"></span>
							兑换积分为余额
						</button>
					</div>
				</li>
			</ul>
		</div>
		<div class="cash-out">
			<button class="cash-out-btn" onclick="wantCashout(this);">
				<span class="loading dn" id="loading2"></span>
				我要提现
			</button>
		</div>
	<?php } ?>
</div>
<script type="text/javascript">
	function wantCashout(othis){
		var loading = zjh.get('loading2'),
			eleM = zjh.get('money');
		if(eleM.innerHTML.trim() == 0){
			alert('您的账户中没有余额，不能提现');
			return;
		}
		zjh.show(loading);
		othis.disabled = true;
		zjh.POST('<?php echo HOSTNAME?>amount/cashout',{'r':'abc'},function(r){
			r = eval("("+r+")");
			if(r.tag == 'fail'){
				alert(r.info);
			}else{
				countdown({
					from:parseFloat(r.money.from),
					to:parseFloat(r.money.to),
					speed:10,
					timefn:function(ret){
						eleM.innerHTML = ret;
					},
					endfn:function(){
						alert('您已经成功提现'+r.money.from+"￥，您可以查看提现记录");
					}
				});
			}
			othis.disabled = false;
			zjh.hide(loading);
		});
	}
	function countdown(params){
		var from = params.from,
			to = params.to,
			speed = params.speed ? params.speed:100,
			times = 40,
			step = (to - from)/times,
			tag = 1;
		
		void function(from){
			var ret = from+step;
			var arg = arguments;
			if(tag < times){
				if(typeof params.timefn != 'undefined') params.timefn(ret.toFixed(4));
				setTimeout(function(){
					arg.callee(ret);
				},speed);
			}else{
				if(typeof params.timefn != 'undefined') params.timefn(to);
				if(typeof params.endfn != 'undefined') params.endfn(to);
			}
			tag ++;
		}(from);
	}
	function transfer(othis){
		var eleS = zjh.get('score'),
			eleM = zjh.get('money');
		if(eleS.innerHTML.trim() == 0){
			alert('您的积分为零，无法兑换积分');
			return;
		}
		othis.disabled = true;
		var loading = zjh.get('loading');
		zjh.show(loading);
		zjh.POST('<?php echo HOSTNAME;?>amount/transfer',{'r':'abc'},function(r){
			if(r) r = eval("("+r+")");
			console.log(r);
			if(r.tag == 'success'){
				countdown({
					from:parseFloat(r.score.from),
					to:parseFloat(r.score.to),
					speed:10,
					timefn:function(ret){
						eleS.innerHTML = ret;
					}
				});
				countdown({
					from:parseFloat(r.money.from),
					to:parseFloat(r.money.to),
					speed:10,
					timefn:function(ret){
						eleM.innerHTML = ret;
					}
				});
			}else{
				alert(r.info);
			}
			othis.disabled = false;
			zjh.hide(loading);
		});
	}
</script>