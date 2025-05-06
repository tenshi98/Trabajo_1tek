    TweenMax.to(".mgrotate", 9, {rotation: 360,
        transformOrigin: "50%, 50%",
        repeat: -1,
        ease: Linear.easeNone
    });
    TweenMax.to(".windmill", 4, {rotation: 360,
        transformOrigin: "50%, 50%",
        repeat: -1,
        ease: Linear.easeNone
    });
    TweenMax.to(".wind", 4, {
        opacity:0,
        repeat:-1,
        yoyo:true,
        ease: Power4.easeOut
    });
        TweenMax.to(".wind1", 2, {
        opacity:0,
        repeat:-1,
        yoyo:true,
        ease: Power4.easeOut
    });
    TweenMax.to(".mgwebpage", 3, {
        y:-10,
        repeat:-1,
        yoyo:true,
        ease:Expo.easeOut
    });
    