$(document).ready(function() {
    const headerTop = $('.header .header-top')
    const headerBot = $('.header .header-bottom')
    $(window).scroll(function() {
        const scrollValue = $(window).scrollTop()
        if (scrollValue > 0 && scrollValue < 600) {
            headerTop.addClass('scroll')
            if (!($('.live-search-result').hasClass('active'))) {
                headerBot.addClass('scroll')
            }
            headerBot.removeClass('hide')
        }
        else if (scrollValue <= 0) {
            headerTop.removeClass('scroll')
            headerBot.removeClass('hide')
            headerBot.removeClass('scroll')
        }
        else {
            headerTop.addClass('scroll')
            headerBot.addClass('hide')
        }
    })

    $(window).scroll(function() {
        const headerMobileTop = $('.header-mobile .header-top')
        const headerMobileBot = $('.header-mobile .header-bottom')
        const scrollValue = $(window).scrollTop()
        if (scrollValue > 10) {
            headerMobileTop.addClass('scroll')
            headerMobileBot.addClass('scroll')
        } else {
            headerMobileTop.removeClass('scroll')
            headerMobileBot.removeClass('scroll')
        }
    })
    
})

