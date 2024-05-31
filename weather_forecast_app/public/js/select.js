// 画面が読み込まれた時
$(function(){
    
    // 都道府県が選択された時
    $('select[name="prefecture"]').change(function(){
        let prefectureId = $('select[name="prefecture"]').val();
        let citySelect = $('select[name="city"]');
        const jsons = $('#json-data').data('json'); // 全部のjsonデータを取得する

        // 各都道府県を順に呼び出し
        jsons.forEach(function(prefecture) {
            if (prefectureId == prefecture.id) {
                let cities = prefecture.city;
                citySelect.empty(); // 既存のoptionタグをクリア
                citySelect.append('<option value="">選択しない</option>'); // デフォルトオプションを追加

                // 選択されている都道府県の中の市区町村を<select>タグ内に挿入
                cities.forEach(function(city) {
                    citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                });
            }
        });
    });
});