<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="header-top">
            <div class="header-main">
                <div class="header-left">
                    <div class="site-logo">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAARgAAABuCAMAAADLXPzWAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAJkUExURUxpcRAjTg8lTxElTA8jTRAkTREjTA8jSw8iTw8lTQ8fTy9//yef/z/P7xElTg8kTQ8iTQAAAA8jTBEiTQ8kTSfX7w8jTA8fPx9v/yqf/2PH9yuT+yra8Fe/9yaU/jGZ+zuv9y+/+z209yBh/zaV+jKM/w4kTiOR/zq79SuK/yBg/z+x9UrP9CWW/zLj6GfL9yFj/yFi/yN1/SyV/SCW/yOR/ymf+yKx/zOd+iqg/RyS/zm6+CFh/zOf+VzG92TL9yvb6wS9/S/f5wW+/zXB/km49FbA9GDF9h/C9DS0/C+I/DzO/TSh+kq39WTM9hfQ9B3R8imw+UCx9B9r/yKY/x6q/zWZ+xyz/WrL9ibX7i/g6SBc/yJo/0m49Dyr8zmd+Dyr9TOL/SOy+yLL8jDZ8B9a/zXk5x9f/xEjTjHF+iuZ/zna/yVw/B9f/xCr/2nK9zjn5Trp4zfQ/yNx/SKG/0vW+Q6w/0rU+hAlTRElTiCM/yCU/yBg/yBc/yCP/y3e7BSf/xiY/z6u9CFj/x+R/yDX8jWL/zPk6VS+9i+W/jnn5izY7QG+/z/s4yvM7w7J+ke19A6p/yJo/zuk+AbE/SCX/xGk/xXO9zaR/Qys/xrR9CzR7iRy/irG8Si39Sfb7iex9inB8jGz/yV4/kKy9GnM9ziX+yi88yar+AO6/zTA/yJt/zO6/zGd/AW3/we0/yWl+RyT/wqw/yyI/U259Tqd+TjT/zre/yuB/S6O/Dq3+jWl+iul/znY/zyo9jiu+jfP/zXF/yOb/Cl8/WLH9zbK/1zC9j3C+SSg+yGC/0LN+SG0/8BHFgIAAAB5dFJOUwCfMO+Av99AIGAQECAQ/q9gAZDPcCBQECAwfEBfIJ+AQECWeu9/oJBatl+AMF96QKLf38+/gFBgr9/fb7+QosXf30Bf7sLfj3vHcINw71aj792vQO+/34ffyafvz9/fv+/f59+PMO9Q3qBv5++Q3+/cvMqQ7/ug347sPozVAAARJklEQVR42u2ciUNTV9qHT0Lukq3REMIqO7JvIvtmLUhRREUR667V2lq36ToVa6swDszKB+OMbemmoq1AWwf4Wi2jfrXa1v5T39lu3ntuknt1mI6DkyfhbiTgefI77zm5N4hixIgRI0aMGDFixIgRI0aMGDFi/IfgLUkrKytLW41iAAll20/8UeNXMTcMb9mv/iiyPQFFYPWB7aswz20v+68wtxqsACfCzZRt/D3hHcoLoO5JDcsLv4vICS8SOfDBB1gLqFnlRU8waaDFSJnhkR8Q9GbSnuRO9FvMC2WrvSgh7cRvRU4ggef+ZDCz6ontS94DpP2hESjhBYMZpCfrTxhqhmEIzJPUrUpW0bToigjz8Q65YUQxzxMx+tBsh5F+3ctff/31y6+kJTwh1cXYHQreEXhOePSHHxIxEBp45oF/fK1x4AlQU0bb7hUqjihmOwISnv8QozdTovWhV/5B4GZeLln0efn443c+5l7gmEAaAl769EMwQygLfed/MTo3kYcqu+OhQI+EU3yOSncTrZ6gIDMSVuGWG4eV7aIYnbWsTzHUDFdzICTzzp072AzIiWwm+NbDIDOJNhOcKIRCn2Mz7KsoOhJ5gLn9tN9gCgyyfiOwQfedTZ+KZp4PSXvl3r07opuIvcklW0mBf7Nq9RCOBCL+dWKewy3fiAhgZwPR8XFIzGpdR7p69So1QyBeEkLK7lHuhOQQMygCqrWZOD9i+EwypRpC6HOGcNADATiQiIJOgXj2DIEgEtjIxXg3JIiBeV+768ak2o+uYiA0G6ELFvwf5t69tkYvKnlJc7MORcKlUuLewvhVDfpvleimK/RIvxxFnWRHIdhj7Cam7VixJfFhYt5/v2z1sxvLIDDvC0Cp8Oz/SDRToHN27RpRk8DUvsJy87LJbM/FXlYx3RJ6dJy8wkhmFStgLcZv6Eq8+c9DHQEn8A3Kpo8wVwnMTCMSxGA1Pbg8Z6/Lwn2Odap1KCrsFVYWLkbmFUWNZkYivc5h5cVnLL5/o+g6xYa/CUBg+j4hYiA0zyIdyVPEzEsom+RmHTGDudMWPTJBFvKFiYHAUNcKg8XDyfdUXtsUxceSoQjAowDwsLEEAiN6gcA0foJhZgjMC9A2NTV1rS3rGk1OFp7u3SNEjQwPd+ICxUBgMBajEqtqstihoe6GkbZhw7Nenag/C6RBgflEMMO8AMVThLYpaqYRC24j1bgNRcNPiyhaoBgIjLUYGwsSEpCg1JmTIHp5OuRl02efgRnqRcS76eLFi1OMa9kkYbQaZ6Eo0FzHL1gMBAamvFwMnWRDk4NhCmGuFKciK54VxTyDOHWfYT4JqQEvUGXasBnuhg5XnaRTdZrOsXwLFSMGJshSqIkRO6sMlQfQCo9kGZin/6InFJiMr4gYrsbgBUJ1kTFVjAi03kD5hUkMTGNsagiJJkjlPFpgJBt7goOlkItxQXm3HpaCVoH5i4AWmK6vMGCmFkWmtpN46axBjM4pXHGyjC+xFbz22J2WBMm7KVYkFOievlCNoe6XQOU1Iy4RmRI5MMk/fqUzs78GRcXr8UBEsqYw2eHzOmts8ApbzVUVnRg6e3ZoYtiuHyqvKb9GZjzzBwEeGE/9jzozm5LRw9KJK05n2DBtjaySBlviN4hhEQmGxCyHMuZSLDEPjOCFB8Zd/92PYGaTBwks604hlC9D4TRexCADasCBYTXPAcjUCN10uqAomCC5DGLsvKhoYgK6eYvLZoH66IFZ+d132AxX0+tGOso7tk1MTBzfdhwvt7WUh3UsIiY8YNBsZDYqqQrFz2bsihFSVUEMbGprlQ/QMCybopgG5vM/4BuBrHhg8s9/B2aaBS2tE8c7uktKyrvLy8u7W7ZNbOtGIr1YTMRKzWIebypGfPOMogBiWELiQYzK1gsX88znAiww1efPUzO0Ox3W96HWidby8pTWCQwNDBHVKvaorvmLF7sQEObBWowCddZKjJ9GC8RowxKIkSMRZymml/r44vMvyP2Lp5mX/n5shoWmPhUBKce3lZd3pEwA+GD3tokUYdI3Pz+fjQzAAGKzFgMTeWsxEqvIICZeOBsYrfVOKzFZXwjQwJSeHhzsx16ImSqP3stESwkOS/fExPcaNCwd3+vNuLGYOhQJVnutxagwyzAXA4MSiFkO9hci5g3q48sv8ZcWmOTTp5kZ7CYf6b18n1KyDctISWlpPY7Xx1s7WjqomZT7ejP18/P10U9TLbEWY4M5v5UYF9sCMXwmrBcsh2MpxvOlwDPEy2snTxI1uDttqTF46SYhafWyz191dKy5j6FKCvRm6qZBTITmWImB0ited3Haw38S30rUiXFSGebF11rMG4KXY0RVw0kMNUO6EdB9P6WEiFizjNfh+5ShIXygJKVjCMbt9OnpepPTVKZiIObx2hYQr4aJCXANIIYPS2Zi4hQrMZ6/C+DAJK346SduJl+c061pXbaGeWF4hyj38Vf50FBL+xov4uQPg5jw+S8yFwNviUEMtEicx2iDkgRitM4VBDE2h4GAallj3hC8HGNemJmGVCTQMbSsZYjGQ4OJmWVihhrXFyNO9fBwlclpKisxCpReUQw/CmJgUAIx3GtgQcXX897f3yN3Ti32cuknysl8N60jEJihlALipUMvZhbfyDJraHZ2V/Z6L4hZGfU0lWQuRiy9LhVwyjCmgZh4zQKI8dGngxi/MxwLMX3v6TnmwV4uUTOv0arrbQULLUPL1gwNtbfoIjMbomA9XhSHIlN9Y7gw6jTGZyoGCoM98iAuG8TwDRDDgxlvPvO1EHNMENOXtGL8EjVT6KYhebMFhdjV4l0/m92OBezSzPTMjuDdkZHZkcZdIyMj7cXrQ2Ju5KMIsKttZmIgMPHRxIpi4IQdiGHDkqkYm7mY2v8RSF0xOU7MrNjMRqHXX4eelDmbiTKzcTCwjF1etKwgu339rnbsg1LcTpcjmVzMzMxak6ttFmKg9BqRwsUEmQTh/TfIUqNdDXaZizkmeFlZOTmJzYy/SuPiXff662+iECQNmSOczPV8o6fnMiU7myyL9zbyUWlmJjXq1baghRgnFFkAbMSLYhz0B4hi4OymdfF9mMBMjo5iMztZXLLefPDgwToUor0dxFzOvKyxO3v35bO7s5Mzz2J6enoQpXBmxm0yvzMRAyd0FSNBRxxPEvwo7bymKIb9iCX/vJhjf9VzcmBgdPRIDiIktD8gZKEQndkIaT724o2zZ/GdkN2YjDB78ebu4t1czDf7rK+2gRifaM8UWXSsvWO0aaeBfTabA4ZwgxiXBMjRxaT+VWByYGCgIon1ogcPfsC0IeByMRZzltHZeBbYy7sa2S7gO699Uxj1NJU/vGrYxdJrhqzqxdhhUILiC2ciYBLMccWFfyIiAr06K+++e/3tU02bmZa2HxjtCDhbAGJ6itn6FrntQRTv3lu3bhXcQgT33bulKAJ+WZYdSGC5LEuKOCSbEOdw6XPl42VLQgYxqsyzpRreiwaiX9MHPO8KjO8oQoQCbuXmDzezI4nB7W/uucUZu3VLe1D22NhYwRgibL50KQn9k6hKdOwuqOOS5HO4YE0PEVhHVf14k6zJt4XK4pMA/kwj6YKXLTluNsHddTNEIwL2FuMk7GU6uvaMARmIkbwnd6w0FxFyLu1EixZjYLTsZ98EChCwuxm5mzOZi5rdY0CN9vOau0ozqhChabwILV7ymZAz9OtMg9a8mzdv37zNyURA3R737rHmLqIi17N1bG5uDn8R+ITFvXVuLreujm5OjiehxUsD1UKt4Hs6YhTfBgQxXblubKErY24u3Y082AJja3qdh4m7cuVK3dYuhDk0WYEWL6VnBDyI0Xn79re3v+WUIiB1LnUPyUcGTYgbe8Dk7qnCS1JlMshu8xU6pakYPbSYAyN40QLjYUZADJDb3IXbvpUaZCZy07EWwh5P3gVMbuFWhEkaqESLl5rIganBOqa/neY0Ix0ZuZ5cIiG0n153QSMvlyzT961FmKKBxVx6V545cx3f+W1lqLVcydz0FXyrQzrcuXk0F27EKeRWzl04t/YcZl/+Oeq3cjEHxnMdwGZKQczwML5zcpGevNzkfSQdob51ToOJyduXRwNzKmKF8dtsCrJA9fsT0eMl/bqeBjg+fAULucJvN1KFyOwrTMXtz9V2wUtVIV6kp+9zk8OVkYckGa4nmX3W3/a4AzN4fRAohVTcEMhDelLP5ZFocFvJIKaw6sKFqvwLdEjKqUxaiBjpMY/VgwIepLGWG5m5MUNg6QBt5/LysAaSC4/HQ/rVMCHf7TlceHg4gw5Jbx9EpmJcJp+1s8dL6mMeq0/rSdcNVjMiqQYzF/LyhkurqI6thzO2kvVKGpTD09QLqsxBpmLUeOHitSvoDNphT1VdbE02GODx30DqSQFd690zM9/oKUQiGcPNqRlExzSmPiNjesth+rTmeeal4igyFaPKei/87wBkJ6IsXc5rTGJc6ISAKnhcKssv2tlhRpzkRGEoAZvfCXu47PuDsKsoyOUMkIEg6AgaS6/gpQHpKNRruXv37lokcnhLfWlp/TynPtVDRddvqWWJWuE2FaPE6c9y2/EewwFitDNaTyXSQ/i01YsqVUF38XEFxFACSMQl6T85YJfFE1wq3nTQX0mzKxl6kiAmH+lYe1fkiLGUeurme2tSm6uYGeIlq/ezXlalXl2RhMzEBNhVYwpPj+RYTlYBUYxdk6ViEwFmyCjmKaeiBOTws+a4vSBGJe7lOPgUOBiNcC0i+aRAsjAmH8GXT+5eAsLbWts7v+mNmuTkzMzMZE9N3/6fe7PYUysiegEx8fzaM5zDlBX6AULeOhCzVCKHeGCYqqfCxKi8ncGwc9xSUHEy/zL7HUG8lkJiZPYZSb8fC7MJqTh5ml60xyu8fA0J5GAZ45fG8Z0DrQWzfZt+/vnn/fv3k2Uf04KSdkb0AmIwghj6erGSwmIBYpBCksJWTlZcIonhQTQGRhZOrKvChso2mBK/oS8VntbD6ytEZtwAv/wm4s2q7evrq83yhoQe2ZmErMWAGQVv85LqZ0J0YpbSl3ippAVmyVtRxEhGMUKxdvLLUCBQZb9VokFzGsRUCWLykcjaSRF8renVJGRBUtNkhRtZiZEUGczY4aUNiGK08qssgcA8ihg/iAn9jjj4XIjMnqaEiyGfIxvEC3zDy2pk4NVRwiRd8q3KImSGO+fIaA4yR6aNVsGMi7aN50EUw0dsSYbrjg8nhleVUDm26y+t2C3FDAqkIyMVowID5KuyKClqWnJ2jFZCdzMbrsEMK7BSYrgY6F4YpgHZyfBtLsZlh2tXslPhUxSJfxAfiq+ZmC2D+ON1+Isw2L/FjQC3h+wdHYhExSF3pLA04W8dFb5j/pYgnprhr+KLTiXoFMRE/Dv8RLz5a3MxPt5GlzBc2+lILZOFai2mql8PfNDOXVpYwyupXsgpcmc0HT10EJwcLDq6kxzdCXGxEgNm4M8GpDAxPFC08bAjS5IUXYyklVl1ecQJnh1Zi6nuN7Ayv7o6P72hP98d6h4Vp6KyY2cTpnIH34X6Yy2GkujTzATkiGIgMjbjH/pHF6M61NAzHTZbwIU4Qb/P5oer14piZ395ix+g0h3A3XC+v5/cyYKuzpMv9m4Q1FSeegiaLLXAexSXbtvOWuP0Sb4AXjlZiaRrzhLWdmgthx5z4Y1E/h98QNsWTHLDeSNb8jUtQFHT2+bsqNiMfimWyo/jrJUnXbSSnhq5erqLKiqjWylyo1+OJfTd478fd2p1+kpCenWpB5lx8NDRph0GJzsrcqAI/2KBcaD/fNwHNxcV5RCKDh2EGc0vGxgUAxBO5sWIESNGjBgxYsSIESNGjBgxYjwZ/D/EvSinkw1iWwAAAABJRU5ErkJggg==" alt="logoIcon" class="logo-icon" />
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'main-nav',
                            'menu_class' => 'main-menu',
                            'container' => false,
                            'fallback_cb' => 'kaiyun_sports_fallback_menu',
                            'walker' => new Kaiyun_Menu_Walker(),
                        ));
                        ?>
                    </div>
                    
                    <div class="header-right">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'utility-nav',
                            'menu_class' => 'utility-menu',
                            'container' => false,
                            'fallback_cb' => 'kaiyun_sports_utility_fallback_menu',
                            'walker' => new Kaiyun_Utility_Menu_Walker(),
                        ));
                        ?>
                        
                        <div class="login-section">
                            <div class="login-form">
                                <input type="text" class="login-input username-input" placeholder="账号" maxlength="32" value="phong2k3" />
                                <div class="password-section">
                                    <input type="password" class="login-input password-input" placeholder="密码" maxlength="32" value="••••••" />
                                    <div class="forgot-password">忘记？</div>
                                </div>
                                <div class="login-buttons">
                                    <button class="login-btn">登录</button>
                                    <button class="register-btn">注册</button>
                                </div>
                            </div>
                            <div class="permanent-url">
                                <span>永久网址: kaiyun.com</span>
                                <span class="search-icon">🔍</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php
// Fallback menu function for main navigation
function kaiyun_sports_fallback_menu() {
    echo '<ul class="main-menu">';
    echo '<li class="menu-item current-menu-item"><div class="menu-item-content"><p>首页</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>体育</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>真人</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>棋牌</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>电竞</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>彩票</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>电子</p></div></li>';
    echo '<li class="menu-item"><div class="menu-item-content"><p>娱乐</p></div></li>';
    echo '</ul>';
}

// Fallback menu function for utility navigation
function kaiyun_sports_utility_fallback_menu() {
    echo '<ul class="utility-menu">';
    echo '<li class="utility-item"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAnUExURUxpcXmBo3iBo3d/pHd/n3iAo29/n3iBo3mBpHiBo3h/ond/o3mBpJzE3UMAAAAMdFJOUwDfoWAgfBDPv++QQCPQQ9MAAACoSURBVEjHY2AYBcMOsHSeQQMnVVAUOJ7BAAcTkBXoYCo4E4CsYA4WBQLICs6MKhhkCoKNIUAHlwJYBK/BpaABypPBpeAohMOK25EQO2JwKzi+Acjegc+bB7WiNAdtUMtgUdCArCAGiwIDZAUcmPKHULO3kRIQwCyaBOJswFIIQPP48QScpQTEiDLc5YgjfgOgRpThK4oc8RsANqIMf2nmcSJhtEgfrAAAfMvbf+B1k00AAAAASUVORK5CYII=" alt="icon" class="utility-icon" /><div class="utility-text">客服</div></li>';
    echo '<li class="utility-item"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAMFBMVEVMaXFxf593f594f6J4gKN5gaR4gaN3f6N4gaN5gqR3f6N6gqR4gaR4gaV5f6R5gaQsYbKKAAAAD3RSTlMAECCQot/vP8+PY3+/z1Dxqzn3AAAACXBIWXMAAAsTAAALEwEAmpwYAAABDUlEQVR4nO2V2Q6EIAxFpWwKaP//byczo5FKsegsT5wXk5NLraJlGDqdDovXFnE20OoPqAlXJtXiC8YthzhnSVXxBdOeQ5xkfwTyHKKXfIGhQS35szfwxEq+AA9I/vsFLM2Nki/QNGgkX+BpECQvtKBlX6CyDRuV7M960PRnqngGMCOi1b7V/wAVQlykuVEH0rrXcG8iLW57WW4hbZm2ieTz/fY3JpLNC9g9aRonUqCfbGAbO5tIiQYT28DZt+xo0LFPdmUixbeOR99cACO7/kIBjNz6KwUwMusvFWD5X4FALjcKDK+l4ZODJVgX/nky4acFXCVY881/Y2o92oDcyoHkmQpmjyWQfafTGTYelFs+1xc9oCwAAAAASUVORK5CYII=" alt="icon" class="utility-icon" /><div class="utility-text">合营</div></li>';
    echo '<li class="utility-item"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAALVBMVEVMaXF4gaR3f593f6N3f6N3f6N4gaN4gKN4gaN5gaNvf595f6N4f6R/f595gaTTZVnuAAAADnRSTlMAvyBgQIDvmc/fEFBwEF8XaQMAAAAJcEhZcwAACxMAAAsTAQCanBgAAADqSURBVHic7ZbRDoMgDEULSBFh/f/PXRwaJ2hb47KHjfMmkUO5aBWg0+kcMwXEYJvhwWD0qswCzZi0k2bzGs0aAS1Et5YxeVzGRsV8uwqIyk6GsnhBIXisqy01lx1dqADyfsa7D9tsj7B+w0LaLvIEX8AKCEWkSBIjl0MSpwtJGo2AwrmAVDAPA6oE5lwQVAJ3LnjEexEAgDMCgVn/Q0wDizjf7zeMpoolCi+kqxKzzdPFHOLM2N5dO/ldkCzgj4G6AHoG8IMZoG0b5SUBxdB8K64JDuAFhkT4ljTc7OoAqepJFaj70+t0/pAnjH45u8gzxqUAAAAASUVORK5CYII=" alt="icon" class="utility-icon" /><div class="utility-text">优惠</div></li>';
    echo '<li class="utility-item"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAPUExURUxpcXd/n3iBpHiBo3mBpHNl0+MAAAAEdFJOUwAgt+8Q7+fsAAAAVklEQVRIx2NgGAWDDzAqu8CBkwAWBcIuSMAQiwIVoDhYIyPICCwKXJAVOONQgACjCkYVjCoYLAooB5S7wQRagjDiUqCCrMCJnEKMUQUhbyQwWi0MQgAA4UmGJWExm/IAAAAASUVORK5CYII=" alt="icon" class="utility-icon" /><div class="utility-text">APP</div></li>';
    echo '</ul>';
}
?>
