<select class="jcf-ignore" id="{$id}" name="tyre[size_r][]" style="width: 76px;">
    {if $isAll}
        <option value="">Все</option>
    {/if}
    <option value="3">3</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    {if $enableCSize}<option value="14">14C</option>{/if}
    <option value="15,3">15,3</option>
    <option value="15">15</option>
    {if $enableCSize}<option value="15">15C</option>{/if}
    <option value="15,5">15,5</option>
    <option value="16"{if !$isAll} selected="selected"{/if}>16</option>
    {if $enableCSize}<option value="16">16C</option>{/if}
    <option value="16,5">16,5</option>
    <option value="17">17</option>
    {if $enableCSize}<option value="17">17C</option>{/if}
    <option value="17,5">17,5</option>
    <option value="18">18</option>
    <option value="19,5">19,5</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22,5">22,5</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="24,5">24,5</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="28">28</option>
    <option value="30">30</option>
    <option value="32">32</option>
    <option value="34">34</option>
    <option value="36">36</option>
    <option value="38">38</option>
    <option value="42">42</option>
    <option value="48">48</option>
    <option value="420">420</option>
    <option value="450">450</option>
    <option value="470">470</option>
    <option value="500">500</option>
</select>