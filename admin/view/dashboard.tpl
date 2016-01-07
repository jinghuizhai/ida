<script src="<?php echo HOSTNAME;?>style/js/echarts-all.js"></script>
<div class="main-inner">
	<div class="dash-color-block fix">
		<div class="color-block">
			<div class="block-inner b-yellow">
				<h2>
				今日新增订单：<?php echo $today_order;?>
				</h2>
				<p>
				总订单：<?php echo $total_order;?>
				</p>
				<p>
				未成功发送到客户端订单：
				<a href="<?php echo HOSTNAME;?>admin/order/notSend"><?php echo $not_send;?></a>
				</p>
			</div>
		</div>
		<div class="color-block">
			<div class="block-inner b-lightgreen">
				<h2>
				今日新增用户：<?php echo $today_user;?>
				</h2>
				<p>
				总用户：<?php echo $total_user;?>
				</p>
			</div>
		</div>
		<div class="color-block">
			<div class="block-inner b-pink">
				<h2>
				未回复评论：<?php echo $comment_notReply;?>
				</h2>
				<p>
				共有评论：<?php echo $comment_total;?>
				</p>
			</div>
		</div>
		<div class="color-block mr0">
			<div class="block-inner b-blue">
				<h2>
				未审核提现请求：<?php echo $cashout_not;?>个
				</h2>
				<p>
				已审核请求：<?php echo $cashout_has;?>个
				</p>
				<p>
				共体现金额（已经审核）：<?php echo $total_money;?>￥
				</p>
			</div>
		</div>
	</div>
	<div class="echarts">
		<div class="mb20 mt20 tc">
			<h1>
			最近
			<select id="current-days">
				<option selected="selected" value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="60">60</option>
				<option value="70">70</option>
				<option value="80">80</option>
				<option value="90">90</option>
				<option value="100">100</option>
			</select>
			天订单</h1>
		</div>
		<div id="echart-1" style="height:400px"></div>
		<div class="mb20 mt20 tc">
			<h1>全国订单分布&nbsp;全国会员分布</h1>
		</div>
		<div id="echart-2" style="height:400px"></div>
	</div>
</div>
<script type="text/javascript">
    (function(){
    	var myChart = echarts.init(document.getElementById('echart-1'));
    	var selectEl = zjh.get('current-days');
    	void function(){
    		var args = arguments;
    		var current_days = selectEl.options[selectEl.selectedIndex].value;
    		zjh.POST('<?php echo HOSTNAME;?>admin/order/findCount',{'current_days':current_days,'random':Math.random()},function(r){
	    		if(r){
	    			r = eval("("+r+")");
	    			var option = {
			            title : {
			                text: '本月订单情况',
			                subtext: '按天分布'
			            },
			            tooltip : {
			                trigger: 'axis'
			            },
			            legend: {
			                data:['订单']
			            },
			            toolbox: {
			                show : true,
			                feature : {
			                    mark : {show: true},
			                    dataView : {show: true, readOnly: false},
			                    magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
			                    restore : {show: true},
			                    saveAsImage : {show: true}
			                }
			            },
			            calculable : true,
			            xAxis : [
			                {
			                    type : 'category',
			                    boundaryGap : false,
			                    data : r.days
			                }
			            ],
			            yAxis : [
			                {
			                    type : 'value'
			                }
			            ],
			            series : [
			                {
			                    name:'订单',
			                    type:'line',
			                    smooth:true,
			                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
			                    data:r.counts
			                }
			            ]
			        };
			        myChart.setOption(option);
			       	if(typeof selectEl.onchange != 'function'){
			       		selectEl.onchange = function(){
			       			args.callee();
			       			myChart.setOption(option);
			       			myChart.refresh();
			       		};
			       	}
	    		}
    		});
    	}();
        var myChart2 = echarts.init(document.getElementById('echart-2'));
        zjh.POST('<?php echo HOSTNAME;?>admin/order/countByProvince',{'a':1},function(r){
        	if(r) r = eval("("+r+")");
        	console.log(r);
        	var option2 = {
			    title : {
			        text: '订单会员分布',
			        x:'center'
			    },
			    tooltip : {
			        trigger: 'item'
			    },
			    legend: {
			        orient: 'vertical',
			        x:'left',
			        data:['订单','会员']
			    },
			    dataRange: {
			        min: 0,
			        max: 2500,
			        x: 'left',
			        y: 'bottom',
			        text:['高','低'],           // 文本，默认为数值文本
			        calculable : true
			    },
			    toolbox: {
			        show: true,
			        orient : 'vertical',
			        x: 'right',
			        y: 'center',
			        feature : {
			            mark : {show: true},
			            dataView : {show: true, readOnly: false},
			            restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    roamController: {
			        show: true,
			        x: 'right',
			        mapTypeControl: {
			            'china': true
			        }
			    },
			    series : [
			        {
			            name: '订单',
			            type: 'map',
			            mapType: 'china',
			            roam: false,
			            itemStyle:{
			                normal:{label:{show:true}},
			                emphasis:{label:{show:true}}
			            },
			            data:r.orders
			        },
			        {
			            name: '会员',
			            type: 'map',
			            mapType: 'china',
			            itemStyle:{
			                normal:{label:{show:true}},
			                emphasis:{label:{show:true}}
			            },
			            data:r.members
			        }
			    ]
			};
        	myChart2.setOption(option2);
        });
    })();
</script>
