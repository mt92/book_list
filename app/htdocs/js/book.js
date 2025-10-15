function deleteUser(id, title) {
    // 削除ボタン実行時にダイアログ表示
    if (confirm(`ID:${id} 「${title}」を削除しますか？`)) {
        fetch('book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${encodeURIComponent(id)}&delete=1`
        })
        .then(response => {
            if (response.ok) {
                alert("削除しました");
                location.reload();
            } else {
                alert("削除に失敗しました");
            }
        });
    }
}