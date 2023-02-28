@extends('layouts.main18')

@section('content')
<div class="container-dark container-fluid margin-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="city-dark">Madrid</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="rank-h1">Rankings</h1>
            <h3 class="rank-sub-h3">Demuestra lo que vales</h3>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <select class="form-control sel-font-size" id="id_select_experience">
                    <option value="global" selected >Global experiences</option>
                    <option value="Infinite Realms">Infinite Realms</option>
                    <option value="Beyond Boundaries">Beyond Boundaries</option>
                    <option value="Galactic Odyssey">Galactic Odyssey</option>
                    <option value="Dreamscape Adventures">Dreamscape Adventures</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <select class="form-control sel-font-size" id="id_select_city">
                    <option value="global" selected >Global cities</option>
                    <option value="Alicante" >Alicante</option>
                    <option value="Madrid" >Madrid</option>
                    <option value="Valencia">Valencia</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row margin-row">
        <div class="col-md-12">
            <h2 class="rank-h2">Top 10 Equipos</h2>
        </div>
        <div class="col-md-12 teams">
            
        </div>
    </div>
    <div class="row margin-row">
        <div class="col-md-12">
            <h2 class="rank-h2">Top 10 Jugadores</h2>
        </div>
        <div class="col-md-12 players">
            
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        // change city 
        $('#id_select_city').on('change', function() {
            setCookie("rankings_city", $(this).val());
            datas_by_score($(this).val(), getCookie("rankings_experience"));
            //$('#id_select_experience').val('global');
        });

        // change experience
        $('#id_select_experience').on('change', function() {
            setCookie("rankings_experience", $(this).val());
            datas_by_score(getCookie("rankings_city"), $(this).val());
            //$('#id_select_city').val('global');
        });

        // set selects 
        function selects() {

            setCookie("rankings_city", 'global');
            setCookie("rankings_experience", 'global');

            $.get("/scores.json", function( data ) {
                // select
                let arr_experince = []; 
                let arr_cities = [];
                $('#id_select_experience').empty();
                $('#id_select_city').empty();

                $.each(data.teams, function(index, item) {
                    arr_experince[item.experience_name] = item.experience_name;
                    arr_cities[item.city] = item.city;
                });

                // selects
                $('#id_select_experience').append('<option value="global" selected="selected" >All experiences</option>');
                arr_experince.sort();
                for(exper_name in arr_experince) {
                    $('#id_select_experience').append('<option value="'+exper_name+'">'+exper_name+'</option>');
                }
                $('#id_select_city').append('<option value="global" selected="selected" >All cities</option>');
                arr_cities.sort();
                for(city_name in arr_cities) {
                    $('#id_select_city').append('<option value="'+city_name+'">'+city_name+'</option>');
                }

            }).fail(function() {
                alert('Error loading of data!');
            });
        }

        // datas from json 
        function datas_by_score(select_city, select_experince) {

            $.get("/scores.json", function( data ) {
                // teams 
                data.teams.sort(function(a,b) {
                    return b.score - a.score; // smaller is better..
                });
                let i = 1;
                $('#app .teams').empty();
                $.each(data.teams, function(index, item) {

                    if (((select_city == 'global') || (select_city != 'global' && item.city == select_city)) && 
                        ((select_experince == 'global') || (select_experince != 'global' && item.experience_name == select_experince))) {
                        // 10 teams 
                        if (i <= 10) {
                            if (i <= 3) {
                                $('#app .teams').append('<div class="div-rank my-top-position">'+
                                    '<div class="div-line div-number font-family-futura">'+ i +'.</div>'+
                                    '<div class="div-line div-title font-family-futura">'+ item.team_name +'</div>'+
                                    '<div class="div-line div-score font-family-futura">'+ item.score +'</div>'+
                                '</div>');
                            } else {
                                $('#app .teams').append('<div class="div-rank">'+
                                    '<div class="div-line div-number font-family-futura">'+ i +'.</div>'+
                                    '<div class="div-line div-title font-family-futura">'+ item.team_name +'</div>'+
                                    '<div class="div-line div-score font-family-futura">'+ item.score +'</div>'+
                                '</div>');
                            }
                        }
                        i++;
                    }
                });

                // 
                var players = [];
                $.each(data.teams, function(index, item) {
                    $.each(item.players, function(ind, itm) {
                        // 
                        let player = {'id': itm.id, 'name': itm.nickname, 'score': itm.score, 'team_name': item.team_name, 'city': item.city, 'experience_name': item.experience_name };
                        players.push(player); 
                    });
                });

                // 
                players.sort(function(a,b){
                    return b.score - a.score; // smaller is better..
                });

                i = 1;
                $('#app .players').html('');
                $.each(players, function(index, item) {
                    if (((select_city == 'global') || (select_city != 'global' && item.city == select_city)) && 
                        ((select_experince == 'global') || (select_experince != 'global' && item.experience_name == select_experince))) {
                        // 10 players
                        if (i <= 10) {
                            if (i <= 3) {
                                $('#app .players').append('<div class="div-rank my-top-position">'+
                                    '<div class="div-line div-number font-family-futura">'+ i +'.</div>'+
                                    '<div class="div-line">'+
                                        '<div class="div-line div-title font-family-futura">'+ item.name +'</div>'+
                                        '<div class="div-line div-subtitle font-family-sofia">'+ item.team_name +'</div>'+
                                    '</div>'+
                                    '<div class="div-line div-score font-family-futura">'+ item.score +'</div>'+
                                '</div>');
                            } else {
                                $('#app .players').append('<div class="div-rank">'+
                                    '<div class="div-line div-number font-family-futura">'+ i +'.</div>'+
                                    '<div class="div-line">'+
                                        '<div class="div-line div-title font-family-futura">'+ item.name +'</div>'+
                                        '<div class="div-line div-subtitle font-family-sofia">'+ item.team_name +'</div>'+
                                    '</div>'+
                                    '<div class="div-line div-score font-family-futura">'+ item.score +'</div>'+
                                '</div>');
                            }
                        }
                        i++;
                    }
                });
            }).fail(function() {
                alert('Error loading of data!');
            });
        }

        // set Cookie
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        // get Cookie 
        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        // load 
        selects();
        datas_by_score('global', 'global');
    });
</script>
@endsection 

