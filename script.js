(function() {
    document.querySelectorAll('.copy-button').forEach(function(copyButton) {
        copyButton.addEventListener('click', function (event) {
            const control = copyButton.closest('.control');
            const contentElement = control.querySelector('.copy-content');

            if (contentElement) {
                if (contentElement.tagName === 'input' || contentElement.tagName === 'textarea') {
                    contentElement.select();
                    contentElement.setSelectionRange(0, 99999); /* For mobile devices */
                } else {
                    const range = document.createRange();
                    range.selectNode(contentElement);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                }

                try {
                    document.execCommand('copy');
                } catch (err) {
                    // not supported
                }
            }
        });
    });
})();
