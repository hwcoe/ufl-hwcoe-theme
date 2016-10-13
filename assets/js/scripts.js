// Smartresize
(function($,sr){

  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null;
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100);
      };
  }
  // smartresize
  jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

$ = jQuery;

$(document).ready(function(){
	var $searchForm = $('.search-wrap'),
		$menuWrap = $('.menu-wrap'),
		$body = $('body'),
		$mobileDropdown = $('.mobile-dropdown-wrap'),
		$mobileDropdownTimeout;

	// Run svgforeverybody
	svg4everybody();

	// Main menu mobile
	$('.btn-menu').on('click',function(e){
		e.preventDefault();
				$('.aux-menu-wrap a').off('click.mobileNoClick');
		if($body.hasClass('open-mobile-dropdown')){
			$body.removeClass('open-mobile-dropdown');
		} else {
			$body.toggleClass('open-menu');
		}

		// Mobile dropdown height if VH isn't supported
		if(!Modernizr.cssvhunit){
			$menuWrap.height($(window).height() - 60);
		}
	});

	// Set audience menu via cookies
	ufl_audience_cookie();

	// Remove the loading class to enable transitions
	$('body').removeClass('loading');

	// Show aux menu on smaller width
	$('.btn-show-aux').on('click',function(e){
		e.preventDefault();
		$('.header').toggleClass('show-aux');
	});

	// Dropdown positioning
	function showDropdown(el){
		if($(window).width() > 992){
			var $this = el,
			$offset = $this.offset().left,
			$dropdown = $this.find('.dropdown');

			$('.main-menu-wrap .hover').removeClass('hover');

			$this.addClass('hover');

			$this.removeClass('offscreen full');

			if($dropdown.width() + $offset > $(window).width()){
				$this.addClass('offscreen');
			}

			if($this.hasClass('offscreen') && $dropdown.offset().left < 0 && $(window).width() > 1140){
				$dropdown.css({'transform':'translateX('+Math.abs($dropdown.offset().left)+'px)'});
			}

			$dropdown.find('.col-md-4').velocity('finish').velocity('transition.slideDownIn',{
				duration: 400,
				easing: 'easeOut',
				stagger: 100
			});
		}
	}
	$('.main-menu-wrap > ul > li').hoverIntent({
		over: function(){
			showDropdown($(this))
		},
		out: function(){
			$(this).removeClass('hover');
		}
	}).on('click',function(){
		$this = $(this);
		if(Modernizr.touch){
			if($this.hasClass('hover')){
				$this.removeClass('hover');
			} else {
				showDropdown($this.closest('li'));
			}
		}
	});

	// Main menu focus for accessibility
	$('.main-menu-link').on('focus',function(e){
		showDropdown($(this).closest('li'));
	});

	// Mobile dropdown content
	$('.main-menu-wrap > ul > li > a').on('click',function(e){
		if($(window).width() < 992){
			e.preventDefault();
			$this = $(this);
			window.clearTimeout($mobileDropdownTimeout);
			$menuWrap.off('click.closeMobile');

			if($body.hasClass('open-mobile-dropdown')){
				$body.removeClass('open-mobile-dropdown');
				$mobileDropdown.empty();
				$('.aux-menu-wrap a').off('click.mobileNoClick')
			} else {
				$body.addClass('open-mobile-dropdown');
				$mobileDropdown.html('<h2><a href="'+$this.attr('href')+'">'+ $this.text() + '</a></h2>' + $this.next('.dropdown').html());

				// Mobile dropdown height if VH isn't supported
				if(!Modernizr.cssvhunit){
					$mobileDropdown.height($(window).height() - 60);
				}

				$mobileDropdownTimeout = window.setTimeout(function(){
					$menuWrap.one('click.closeMobile',function(){
						$body.removeClass('open-mobile-dropdown');
						$mobileDropdown.empty();
					});
				},0);

				// Prevent clicks on other links when mobile dropdown is open
				$('.aux-menu-wrap a').one('click.mobileNoClick', function(e){
					e.preventDefault();
				});
			}
		}
	});

	// Header search form
	$searchForm.on('click',function(e){
		if(!$searchForm.hasClass('open-search')){
			e.preventDefault();
			$searchForm.addClass('open-search').find('input').focus();

			if($(window).width() <= 992){
				$('.alert-small').hide();
			}

			// Close the search form on blur
			window.setTimeout(function(){
				$(document).one('click.closeSearch',function(e){
					if(!$(e.target).closest('.search-wrap').length){
						$searchForm.removeClass('open-search').find('input').val('');
						$('.alert-small').show();
					}
				});
			},0);
		}
	})

	// Footer mobile accordian
	$('.footer-menu h2').on('click',function(){
		if($(window).width() <= 767){
			$(this).closest('.footer-menu').toggleClass('open');
		}
	});

	//// Homepage featured story
	// Featured story carousel
	$('.featured-story-img-wrap').slick({
	  arrows: false,
	  draggable: false,
	  infinite: false,
	  fade: true,
	  slide: '.featured-story-img',
	  speed: 400,
	  swipe: false,
	  touchMove: false
	});

	// Switching to a new featured story
	$('.featured-story:not(.active)').on('click',function(){
		$this = $(this);

		// Changed featured carousel
		$('.featured-story-img-wrap').slick('slickGoTo',$this.find('h2').attr('data-index') - 1);

		$storyNew = $this.html();
		$storyOld = $('.featured-story.active').html();

		$('.featured-story.active').html($storyNew);

		$this.html($storyOld);
	});

	// Homepage feature bio wrap
	function bioSize(){
		$activeWidth = 370;
		if($(window).width() > 1220){
			$activeWidth = 570;
		}
		$('.feature-bio-wrap').each(function(){
			$this = $(this);

			$('.bio:first',$this).addClass('active').width($activeWidth);

			$('.bio:nth-child(2)',$this).css({
			  left: $activeWidth
			});
			$('.bio:nth-child(3)',$this).css({
			  left: $activeWidth + $('.bio:not(.active)',$this).width()
			});
		});
	}
	if($(window).width() > 992){
		$('.bio:first').addClass('active');

		// Resize bios
		bioSize();
	}
	$(document).on('click','.bio',function(){
		$activeWidth = $('.bio.active').width();
	  $this = $(this);
	  $bioWrap = $this.closest('.feature-bio-wrap');

		if($('.feature-bios .bio.velocity-animating',$bioWrap).length || $(window).width() < 767){
			return;
		}
	  if(!$this.hasClass('active')){
		  $this.velocity({
		    left: 0,
		    height: 638,
		    width: $activeWidth
		  },{
		    duration: 400,
		    queue: false
		  });

		  $curActive = $('.bio.active',$bioWrap).clone();
		  $curActive.appendTo($bioWrap.find('.bio-wrap')).css({
		    left: $activeWidth + $('.bio:not(.active)',$bioWrap).width() * 2,
		    height: '251px',
		    width: '251px'
		  })
		  .removeClass('active')
		  .velocity({
		    left: 900
		  },{
		    duration: 400,
		    queue: false,
		    complete: function(){
		    	// Remove old active
		    	$('.bio.active',$bioWrap).remove();

		      $this.addClass('active');
		      $('.feature-bio-copy-wrap',$bioWrap).html($this.find('.copy-wrap').html());

		      $('.feature-bio-copy-wrap',$bioWrap).find('h2,h3,p').velocity('finish').velocity('transition.slideUpIn',{
		      	duration: 400,
		      	easing: 'easeOut',
		      	stagger: 100
		      });
		    }
		  });

		  $this.nextAll('.bio').velocity({
		    left: '-=251px'
		  },{
		    duration: 400,
		    delay: 0,
		    queue: false,
		    complete: function(){
		      $newActive = $this.clone();
		      $this.remove();
		      $newActive.prependTo($bioWrap.find('.bio-wrap')).addClass('active');
		    }
		  });
		}
	});

	// Position emergecy modal on smaller screens
	if($('.emergency-modal').outerHeight() + parseInt($('.emergency-modal').css('margin-top')) < $(window).height() - $('.header').height()){
		$('.emergency-modal-wrap').addClass('fixed');
	}

	// Close emergency modal
	$('.emergency-modal-close').on('click',function(e){
		e.preventDefault();
		$('.emergency-modal-wrap').velocity(
			{
				opacity: 0,
				duration: 200
			},{
				complete: function(){
					$('.emergency-modal-wrap').remove();
				}
		});
	});

	// Bio hover effects
	$(document).on('mouseenter','.bio',function(){
		if(Modernizr.touch == false && $(window).width() > 767){
			$(this).find('h2,h3,.arw-right').velocity('finish').velocity('transition.slideUpIn',{
				duration: 400,
				easing: 'easeOut',
				stagger: 100
			});
		}
	});

	// Big list mobile toggle
	$('.btn-mobile-toggle').on('click',function(e){
		e.preventDefault();
		$bigList = $(this).parent();

		$bigList.toggleClass('open-list');

	});

	// Stat block animation
	$('.stat-block-wrap').on('mouseenter',function(){
		if(Modernizr.touch == false && $(window).width() > 992){
			$this = $(this);
			$infoCopy = $('.info-copy',this);

			$statHeight = $this.find('.stat').outerHeight();
			$infoHeight = $this.find('.info').outerHeight();

			$statHeight = (($infoHeight / 2 / $statHeight) * 100) + 50;

			$('.stat',this).css({'transform':'translateY(-50%)'}).velocity('finish').velocity({
				marginTop: '-' + parseInt($infoHeight / 2 + 20)
			},{
				duration: 200,
				easing: 'easeOut'
			});

			$('.info',this).velocity('finish').velocity({
				opacity: 1,
				marginTop: parseInt($statHeight / 2 + 20)
			},{
				duration: 200,
				easing: 'easeOut',
				queue: false
			});
		}
	}).on('mouseleave',function(){
		if(Modernizr.touch == false && $(window).width() > 992){
			$('.stat',this).velocity('stop').velocity('reverse');

			$('.info',this).velocity('stop').velocity({
				opacity: 0,
				marginTop: 0
			},{
				duration: 200,
				easing: 'easeOut',
				queue: false
			});
		}
	});

	// Equal height horizontal scroll
	if($(window).width() < 992){
		horScrollSize();
	}

	function horScrollSize(){
		// Reset height of all horizontal elements
		$('.hor-scroll-el').css({'height':'','width':''});
		$('.hor-scroll-wrap').each(function(){
			$horHeight = 0;
			$('.hor-scroll-el',this).each(function(){
				if($(this).outerHeight() >  $horHeight){
					$horHeight = $(this).outerHeight();
				}
			}).height($horHeight);
		});
	}

	// Stat wrap offscreen listener
	$('.stat-wrap').on('mouseenter',function(){
		$this = $(this);
		$classes = $this[0].classList;

		if($classes.contains('in-right') && $this.offset().left + parseInt($this.width() * 2) > $(window).width()){
			$this.removeClass('in-right').addClass('in-left');
		}
		if($classes.contains('in-left') && $this.offset().left - parseInt($this.width() * 2) < 0){
			$this.removeClass('in-left').addClass('in-right');
		}
	});

	// Audience nav wrap arrow hover
	$('.audience-nav-wrap').hover(function(){
		$(this).find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-up');
	},function(){
		$(this).find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-down');
	});

	// Debounced window resize listener
	$(window).smartresize(function(){
		$windowWidth = $(window).width();
		if($windowWidth > 767){
			// Resize bios on window resize
			bioSize();
		}

		if($windowWidth >= 992){
			// Resize hor-scroll-wrap elements
			$('.hor-scroll-el').css({'height':''});
		} else {
			// Equal height hor-scroll elements
			horScrollSize();
		}

		// Position emergecy modal on smaller screens
		if($('.emergency-modal').outerHeight() + 200 < $(window).height() - $('.header').height()){
			$('.emergency-modal-wrap').addClass('fixed');
		} else {
			$('.emergency-modal-wrap').removeClass('fixed');
		}
	});

	// Styled select boxes
	$('select.styled').each(function(i){
		$this = $(this);

		// Make new HTML select box
		var $styledSelect = $('<div class="styled-select" data-select="select'+i+'" tabindex="0" data-initial-id="' + $this.attr('id')  + '"><div class="selected">' + $this.data('initial-option') + '</div><ul></ul><span class="arw-right icon-svg"><svg><use xlink:href="' + uflAthenaImgDir + '/spritemap.svg#arw-down"></use></svg></span></div>');
		$this.before($styledSelect);

		// Get all options from this select box
		$('option',this).each(function(){
			$styledSelect.find('ul').append('<li><a href="#" data-value="'+$(this).val()+'">'+$(this).text()+'</a></li>')
		});

		// Hide this select box
		$this.hide().attr('data-select','select'+i);
	});
	$(document).on('click','.styled-select a',function(e){
		e.preventDefault();
		$this = $(this);
		$select = $this.closest('.styled-select');

		// Change the text of selected
		$select.find('.selected').text($this.text()).addClass('changed');

		// Hide the dropdown
		$('.styled-select').removeClass('hover').find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-down');

		$('select[data-select="'+$select.attr('data-select')+'"]').val($(this).attr('data-value'));

		// Unbind document close select
		$(document).off('click.closeSelect');
	}).on('click','.styled-select .selected,.styled-select .arw-right',function(){
		$select = $(this).closest('.styled-select');
		$('.styled-select').not($select).removeClass('hover');
		$select.toggleClass('hover');

		// Change the arrow icon
		if($select.hasClass('hover')){
			$select.find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-up');
		} else {
			$select.find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-down');
		}
		// Change the arrow icon
		$('.styled-select').not($select).find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-down');

		// Close the select on blur
		window.setTimeout(function(){
			$(document).one('click.closeSelect',function(e){
				if(!$(e.target).closest('.styled-select').length){
					$select.removeClass('hover');
					$select.find('svg use').attr('xlink:href',uflAthenaImgDir + '/spritemap.svg#arw-down');
				}
			});
		},0);
	}).on('keydown','.styled-select',function(e){
		if(e.keyCode == 32){
			e.preventDefault();
			$(this).addClass('hover').find('li:first a').focus();
		}
		// Down arrow
		if(e.keyCode == 40){
			e.preventDefault();
			$(this).find('a:focus').closest('li').next('li').find('a').focus();
		}
		// Up arrow
		if(e.keyCode == 38){
			e.preventDefault();
			$(this).find('a:focus').closest('li').prev('li').find('a').focus();
		}
	}).on('blur','.styled-select',function(e){
		if(!$(e.relatedTarget).closest('.styled-select').hasClass('hover')){
			$('.styled-select').removeClass('hover');
		}
	});

	// Custom checkboxes
	$('.uf-check input[type="checkbox"]').each(function(){
		$(this).after('<div><span class="icon-svg"><svg><use xlink:href="' + uflAthenaImgDir + '/spritemap.svg#close"></use></svg></span></div>')
	});
	// Custom radio buttons
	$('.uf-check input[type="radio"]').each(function(){
		$(this).after('<div></div>')
	});

  // Menu functionality
  
  var dropdowns = $(".dropdown ul");

  $(dropdowns).each(function(){

    var count = 0,
        items = $(this).children("li"),
        itemCount = items.length - 1,
        itemsWrap = "<ul class='col-sm-4'>",
        dropContent = '',
        featuredImage = $(this).children(".featured-nav-image");

    $(items).each(function(){
      var splitWrap = "</ul><ul class='col-sm-4'>",
          itemHTML  = $(this)[0].outerHTML;

      if( count == 0 ){
        dropContent = itemsWrap + itemHTML;
        if( count == itemCount ){
          dropContent += "</ul>";
        }
      }
      else if( (count + 1) % 4 == 0 && count != 0){
        dropContent += itemHTML + splitWrap;
      } 
      else if( count == itemCount ){
        dropContent += itemHTML + "</ul>";
      }
      else{
        dropContent += itemHTML;
      }
      count++
    });
    $(this).html(dropContent);
    if(featuredImage){
      $(this).prepend(featuredImage);
    }
  });

  // Modify main menu to appropriate width based on 
  // total menu items
  var menuItems = $(".main-menu-item"),
      menuItemsCount  = menuItems.length,
      menuItemsClass  = "menu-items-count-" + menuItemsCount;

  menuItems.addClass(menuItemsClass);
  
  // Add styling classes to last breaker
  $(".home .footer-wrap").prev().addClass("last edge-blue-bottom");

  // Courses Filter
  $("#courses-search").unbind("keyup").keyup(function(){
    var val = $(this).val().toLowerCase();
    $('.entry').each(function(){
      var text = $(this).children("h2").text().toLowerCase();
      (text.indexOf(val) >= 0) ? $(this).show() : $(this).hide();            
   }); 
  });

  // Faculty Filter
  $("#experts-search").unbind("keyup").keyup(function(){
    var val = $(this).val().toLowerCase();
    $('.directory-entry').each(function(){
      var text = $(this).find("h4").text().toLowerCase();
      (text.indexOf(val) >= 0) ? $(this).show() : $(this).hide();            
    }); 
    if( val.length ==  0 ){
      $(".directory-item").removeClass("keyword-search");
      $(".directory-item.active").children(".directory-entry").show();
    }else{
      $(".directory-item").addClass("keyword-search");
    }
  });

  // Smooth scrolling
  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top - ( $(window).height() * .20)
          }, 600);
          return false;
        }
      }
    });
  });

  // Scroll to top
  // browser window scroll (in pixels) after which the "back to top" link is shown
  var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //grab the "back to top" link
    $back_to_top = $('.cd-top');

  //hide or show the "back to top" link
  $(window).scroll(function(){
    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
    if( $(this).scrollTop() > offset_opacity ) { 
      $back_to_top.addClass('cd-fade-out');
    }
  });

  //smooth scroll to top
  $back_to_top.on('click', function(event){
    event.preventDefault();
    $('body,html').animate({
      scrollTop: 0 ,
      }, scroll_top_duration
    );
  });

  // Move sidenav to bottom of page-content if on mobile
  if( $(window).width() < 768){
    moveSideNav(true);
  }

  $(window).resize(function(){
    if($(window).width() < 768){
      moveSideNav(true);
    }else{
      moveSideNav(false);
    }
  });

  function moveSideNav(move){
    var navCont = $('.post-content-box .row .sidenav-container');
    if(move === true && !navCont.hasClass('moved') ){
      navCont.appendTo('.post-content-box .primary');
      navCont.addClass('moved');
    }

    if(move === false){
      navCont.prependTo('.post-content-box .primary');
      navCont.removeClass('moved');
    }
  }
  // Fix menu functionality
  $("#menu-main-menu").click(function(){
    $(".mobile-dropdown-wrap").show();
  });
  $(".icon-close").click(function(){
    $(".mobile-dropdown-wrap").hide();
  });
});
