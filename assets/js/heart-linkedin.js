document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rafy-heart-group').forEach(function (group) {
        const postId = group.dataset.postId;
        const heartImg = group.querySelector('.rafy-heart-image');
        const text = group.querySelector('.rafy-heart-text');

        const isLiked = () => group.dataset.liked === '1';

        const setLiked = (liked) => {
            group.dataset.liked = liked ? '1' : '0';
            heartImg.src = HeartLinkedinVars.pluginUrl + (
                liked ? 'assets/img/heart-red.png' : 'assets/img/heart-empty.png'
            );
        };

        const toggleLike = () => {
            fetch(HeartLinkedinVars.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'heart-token': HeartLinkedinVars.token,
                    'X-WP-Nonce': HeartLinkedinVars.nonce
                },
                body: JSON.stringify({
                    post_id: parseInt(postId, 10),
                    user_id: parseInt(HeartLinkedinVars.userId, 10)
                })
            })
            .then(response => response.json())
            .then(data => {
                setLiked(data.action === 'liked');
            })
            .catch(error => {
                console.error('Erro ao enviar like:', error);
            });
        };

        const handleClick = () => {
            if (HeartLinkedinVars.userId == 0) {
                window.location.href = '/assinatura';
                return;
            }
            toggleLike();
        };

        [heartImg, text].forEach(el => {
            el.style.cursor = 'pointer';
            el.addEventListener('click', handleClick);
        });

        heartImg.addEventListener('mouseover', function () {
            if (!isLiked()) {
                heartImg.src = HeartLinkedinVars.pluginUrl + 'assets/img/heart-black.png';
            }
        });

        heartImg.addEventListener('mouseout', function () {
            if (!isLiked()) {
                heartImg.src = HeartLinkedinVars.pluginUrl + 'assets/img/heart-empty.png';
            }
        });
    });
});
