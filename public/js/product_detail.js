$(document).ready(function () {
    $('.btn-consult').on('click', function () {
        $('#consultModal').modal('show');
    });
    $("#consultModal .close").on("click", function () {
        $('#consultModal').modal('hide');
    })
    $("#btn-consult").click(function () {
        var formStatus = $("#form-contact-modal").validate({
            rules: {
                name: "required",
                phone: "required",
            },
            messages: {
                name: "Enter your name.",
                phone: "Enter your phone number.",
            },
            onfocusout: false,
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
            }
        }).form();
        if (true == formStatus) {
            popup_load_on();
            var form_data = new FormData($("#form-contact-modal")[0]);
            $.ajax({
                url: "/lien-he/gui",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (result) {
                    popup_load_off();
                    if (result.status == 'true') {
                        $('#consultModal').modal('hide');
                        $('#consultModalSuccess').modal('show');
                        $('#form-contact-modal').trigger("reset");
                    } else {
                        $('.contact-error').html(`<p style="color: red">${result.message}</p>`)
                    }
                }
            });
        }
    });

    // load more description-content
    $(".tab-pane .more").each(function () {
        var content = $(this).siblings(".content");
        var maxHeight = parseInt(content.css("max-height"));
        if (content.height() >= maxHeight -12) {
            $(this).show();
        }
    });
    $("#myTab li.nav-item").on("click", function () {
        var id = $(this).children("button").data("bs-target");
        var content = $(id).children('.content');
        var maxHeight = parseInt(content.css("max-height"));
        setTimeout(function () {
            if (content.height() >= maxHeight -12) {
                $(content).siblings(".more").show();
            }
        }, 200)
    })

    $(".read-more-btn").click(function () {
        $(this).parent().toggleClass("expanded");
    });

    // add to cart
    $('.add_to_cart').on('click', function () {
        $('#add_to_cart').submit();
    });

    // slide show
    var swiper = new Swiper(".brandSwiper", {
        slidesPerView: 6,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".brand-list .next-btn",
            prevEl: ".brand-list .prev-btn",
        },
        breakpoints: {
            320: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            576: {
                slidesPerView: 4,
            },
            992: {
                slidesPerView: 5,
            },
            1200: {
                slidesPerView: 6,
            },
        },
    });
    var mainSlider = new Swiper('.main-slider', {
        slidesPerView: 1,
        spaceBetween: 13,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".main-slider .swiper-button-next",
            prevEl: ".main-slider .swiper-button-prev",
        },
        on: {
            init: function () {
                updatePreviewWidth();
                updateHeight();
            },
            slideChange: function () {
                updatePreviewWidth();
                updateHeight();
            },
        },
    });

    var thumbsSlider = new Swiper('.swiper-container-thumbs', {
        slidesPerView: 3,
        spaceBetween: 13,
        navigation: {
            nextEl: ".swiper-container-thumbs .swiper-button-next",
            prevEl: ".swiper-container-thumbs .swiper-button-prev",
        },
        centeredSlides: true,
        slideToClickedSlide: true,
    });

    mainSlider.controller.control = thumbsSlider;
    thumbsSlider.controller.control = mainSlider;

    $(".swiper-slide-main").on('click', function () {
        $(".preview-slide").addClass('preview')
        updatePreviewWidth();
        updateHeight();
    })
    $(".overlay").on('click', function () {
        $(".preview-slide").removeClass('preview');
        $('.main-slider').css('width', '');
    });

    function updatePreviewWidth() {
        var previewMainSlider = $('.preview .main-slider');

        if (previewMainSlider.length > 0) {
            // Lấy chiều rộng của ảnh hiện tại khi Swiper được khởi tạo
            var currentSlide = mainSlider.slides[mainSlider.activeIndex];
            var currentImage = $(currentSlide).find('.image');
            var imageWidth = currentImage.width();
            var imageHeight = currentImage.height();

            // Thiết lập chiều rộng của swiper-container
            previewMainSlider.width(imageWidth);

            let width60 = window.innerWidth * 0.6;
            let height80 = window.innerHeight * 0.8;

            if (imageHeight > height80) {
                currentImage.css('max-height', height80);
                if (imageWidth > width60) {
                    currentImage.css('max-width', width60);
                }
                previewMainSlider.width(currentImage.width());
            }
        }
    }

    function updateHeight() {
        var previewSlider = $('.preview-slide');
        var isPreviewSlider = $('.preview-slide.preview');

        if (isPreviewSlider.length == 0) {
            if (mainSlider && mainSlider.slides) {
                var currentSlide = mainSlider.slides[mainSlider.activeIndex];
                var currentImage = $(currentSlide).find('.image');
                var imageHeight = currentImage.height();
                previewSlider.height(imageHeight);
            }else {
                var imageFirst = $('.preview-slide .main-slider').find('.image')[0];
                var imageFirstHeight = $(imageFirst).height();
                previewSlider.height(imageFirstHeight);
            }
        }else {
            previewSlider.height('');
        }
    }

    // dánh giá
    $("#starRating.star i").click(function () {
        const clickedIndex = $(this).data("index");

        $("#starRating.star i").each(function (index) {
            if (index + 1 <= clickedIndex) {
                $(this).removeClass("fa-regular").addClass("fa-solid");
            } else {
                $(this).removeClass("fa-solid").addClass("fa-regular");
            }
        });
        $("#starRating input[name=\"star\"]").val(clickedIndex)
    });
    $("#actual-btn").on("change", function (e) {
        const input = e.target;
        if (input.files && input.files.length > 0) {
            const imagePreview = $(".up-image .list-preview");
            imagePreview.empty();

            for (let i = 0; i < input.files.length; i++) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = `<div class="image-preview"><img src="${e.target.result}"></div>`;
                    imagePreview.append(img);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }
    });
});