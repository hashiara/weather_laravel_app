// 画面が読み込まれた時
$(function(){
    // 全部のjsonデータを取得する
    const jsons = $('#json-data').data('json');

    // 都道府県が選択された時（天気予報）
    $('select[name="prefecture"]').change(function(){
        let prefectureId = $('select[name="prefecture"]').val();
        let citySelect = $('select[name="city"]');

        if (prefectureId === "") {
            citySelect.empty();
            citySelect.append('<option value="">選択しない</option>');
            return;
        }

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

    // 地域が選択された時（路線情報）
    $('select[name="area_code"]').change(function(){
        let areaCodeId = $('select[name="area_code"]').val();
        let railOrderSelect = $('select[name="rail_order"]');
        let selectedAreaCodeId = null;

        if (areaCodeId === "") {
            railOrderSelect.empty();
            railOrderSelect.append('<option value="">選択しない</option>');
            return;
        }

        // 選択地域を取得
        Object.entries(jsons.areaList).forEach(([key, _]) => {
            if (areaCodeId == key) {
                selectedAreaCodeId = areaCodeId;
                railOrderSelect.empty(); // 既存のoptionタグをクリア
                railOrderSelect.append('<option value="">選択しない</option>'); // デフォルトオプションを追加
            }
        });

        // 路線情報挿入
        Object.entries(jsons.data).forEach(([key, data]) => {
            if (selectedAreaCodeId == key) {
                // 選択されている地域の中の路線情報を<select>タグ内に挿入
                Object.entries(data).forEach(function([railOrder, railList]) {
                    railOrderSelect.append('<option value="' + railOrder + '">' + railList.railName + '</option>');
                });
            }
        });
    });
});