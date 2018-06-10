<!DOCTYPE html>
<html>
<head>
	<title>ქართველთა შორის წერა-კითხვის გამავრცელებელი საზოგადოება</title>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.web-fonts.ge/fonts/dejavu-sans-extra-light/css/dejavu-sans-extra-light.min.css">
	<link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/css/style.css">

	<!-- <link rel="stylesheet" href="css/stylereset.css"> -->
</head>
<body >
	<header class="head">
		<div class="container my-container row">
			<ul class="row justify-content-between">
				<li id="talk_btn">მესაუბრე</li>
				<li id="fact_btn">კავშირები</li>
			</ul>
		</div>
	</header>
	<main class="container row">
		<div class="main-container col-8">
			<p>ქართველთა შორის წერა-კითხვის </br> გამავრცელებელი საზოგადოება</p>
		</div>
		<div class="second-container col-7">
			<p class="date">1879 წლის 15 მაისი</p>
		</div>
	</main>
	<aside class="sidebar">
		<div class="search_sec">
				<label for="search_bot">სახელი</label>
				<input type="text" id="search" placeholder="ჩაწერე ვისთან საუბარი გსურს ..">
				<ul id="result">
					<!-- <li class="res"><a href="#">გიორგი ნადირაძე</a></li>
					<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
					<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
					<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
					<li class="res"><a href="#">გიორგი ნადირაძე</a></li> -->
				</ul>
		</div>
		
	</aside>
	<div class="sidebar1">
			<div class="search_sec">
        <form action="{{route('group')}}">
					<div class="form-element">
						<label for="net_name">სახელი</label>
						<input type="search" id="net_name" placeholder="ჩაწერე ვისი დაკავშირება გსურს ..">
						<input type="hidden" name="person_id" id="hidden_net_name" >
						<ul id="result1">
							<!-- <li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li> -->
						</ul>
					</div>

					<div class="form-element">
						<label for="net_fact">ფაქტი</label>
						<input type="text"  id="net_fact" placeholder="მიუთითე ფაქტის ტიპი..">
						<input type="hidden" name="factoid_type_id" id="hidden_net_fact">
						<ul id="result2">
							<!-- <li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li>
							<li class="res"><a href="#">გიორგი ნადირაძე</a></li> -->
						</ul>
					</div>

				
					<label for="net_year">წელი</label>
					<input type="number" min="1800" max="1954" name="year" id="net_year" placeholder="მიუთითე წელი..">
					<button type="submit" id="" class="btn ">ძებნა</button>
				</form>
			</div>
			
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('assets/js/main.js')}}"></script>
	<script>
		var sidebar = document.querySelector('.sidebar');
		var sidebar1 = document.querySelector('.sidebar1');
		var main_tag = document.querySelector('main');
		var talk = document.getElementById('talk_btn');
		var fact = document.getElementById('fact_btn');

		fact.addEventListener('click', fact_right);
		main_tag.addEventListener('click', fact_left);

		talk.addEventListener('click', right);
		main_tag.addEventListener('click', left);

		function right() {
			sidebar.style.transform = "translateX(0)";
		}

		function left() {
			sidebar.style.transform = "translateX(100%)";
		}

		function fact_right() {
			sidebar1.style.transform = "translateX(0)";
		}

		function fact_left() {
			sidebar1.style.transform = "translateX(100%)";
		}



		$('#search').on('input', function()
		{
			var text = $(this).val();
			if(text.length > 2)
			{
				$.ajax({
	            type: "post",
	            url: '/person-filter',
	            data: {text:text},
	            success:function(data)
	            {   
	            	$('#result').children().remove();
	            	$('#result').css('display','inherit');
	            	for(var item in data)
	            	{
	            		$('#result').append('<li class="res" ><a class ="name_list" href="/message/'+data[item].id+'" >'+data[item].name+'</a></li>');
	            	}
	            }
	        	});
	        }else
	        {
        		$('#result').children().remove();
            	$('#result').css('display','none');
	        }
		});

		$('#net_name').on('input', function()
		{
			var text = $(this).val();
			if(text.length > 2)
			{
				$.ajax({
	            type: "post",
	            url: '/person-filter',
	            data: {text:text},
	            success:function(data)
	            {   
	            	$('#result1').children().remove();
	            	$('#result1').css('display','inherit');
	            	for(var item in data)
	            	{
	            		$('#result1').append('<li class="res" ><a class ="name_list" data-name ="'+data[item].name+'" data-id = "'+data[item].id+'" >'+data[item].name+'</a></li>');
	            	}
	            }
	        	});
	        }else
	        {
        		$('#result1').children().remove();
            	$('#result1').css('display','none');
	        }
		});

		$(document).delegate('.name_list','click',function()
		{
			var data_id = $(this).attr('data-id');
			var data_name = $(this).attr('data-name');
			$('#hidden_net_name').val(data_id);
			$('#net_name').val(data_name);
			$('#result1').children().remove();
            $('#result1').css('display','none');
		});

		$('#net_fact').on('input', function()
		{
			var text = $(this).val();
			if(text.length > 2)
			{
				$.ajax({
	            type: "post",
	            url: '/factoid-type-filter',
	            data: {text:text},
	            success:function(data)
	            {   
	            	$('#result2').children().remove();
	            	$('#result2').css('display','inherit');
	            	for(var item in data)
	            	{
	            		$('#result2').append('<li class="res" ><a class="name_list2" data-name="'+data[item].name+'"data-id = "'+data[item].id+'" >'+data[item].name+'</a></li>');
	            	}
	            }
	        	});
	        }else
	        {
        		$('#result2').children().remove();
            	$('#result2').css('display','none');
	        }
		});

		$(document).delegate('.name_list2','click',function()
		{
			var data_id2 = $(this).attr('data-id');
			var data_name2 = $(this).data('name');
			$('#hidden_net_fact').val(data_id2);
			$('#net_fact').val(data_name2);
			$('#result2').children().remove();
            $('#result2').css('display','none');
		});

	</script>
</body>
</html>