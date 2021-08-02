<?php
/**
 * Description
 *
 * @package package
 * @var string $hr_hotel_name
 * @var string $hr_room_name
 * @var string $hr_rate
 * @var string $hr_adult
 * @var string $hr_child
 * @var string $hr_cost
 * @var string $hr_arrival_date
 * @var string $hr_departure_date
 */

?>
<table>
    <tr>
        <td>
            <label for="hr_hotel_name"><?= __( "Hotel name", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="text" id="hr_hotel_name" name="hotel_rooms[hr_hotel_name]" value="<?= $hr_hotel_name ?>"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_room_name"><?= __( "Hotel room name", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="text" id="hr_room_name" name="hotel_rooms[hr_room_name]" value="<?= $hr_room_name ?>"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_rate"><?= __( "Hotel rate", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="number" id="hr_rate" name="hotel_rooms[hr_rate]" value="<?= $hr_rate ?>" min="1" max="5"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_adult"><?= __( "Number of adult", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="number" id="hr_adult" name="hotel_rooms[hr_adult]" value="<?= $hr_adult ?>" min="1" max="10"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_child"><?= __( "Number of child", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="number" id="hr_child" name="hotel_rooms[hr_child]" value="<?= $hr_child ?>" min="1" max="10"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_cost"><?= __( "Cost", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="number" id="hr_cost" name="hotel_rooms[hr_cost]" value="<?= $hr_cost ?>" min="1"
                   max="1000000"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_arrival_date"><?= __( "Arrival date", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="date" id="hr_arrival_date" name="hotel_rooms[hr_arrival_date]"
                   value="<?= $hr_arrival_date ?>"/>
        </td>
    </tr>
    <tr>
        <td>
            <label for="hr_departure_date"><?= __( "Departure date", HR_PLUGIN_SLUG ) ?></label>
        </td>
        <td>
            <input type="date" id="hr_departure_date" name="hotel_rooms[hr_departure_date]"
                   value="<?= $hr_departure_date ?>"/>
        </td>
    </tr>
</table>
