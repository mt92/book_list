function deleteUser(id, title) {
    // 削除ボタン実行時にダイアログ表示
    if (confirm(`ID:${id} 「${title}」を削除しますか？`)) {
        console.log("削除");
    } else {
        console.log("キャンセル");
    }
}