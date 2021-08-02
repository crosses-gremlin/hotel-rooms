<?php
/**
 * Description
 *
 * @package package
 * @var object $data
 */

?>
<?php foreach ( $data as $room ): ?>
    <div class="hotel-room">
        <div class="hotel-room__img-block">
            <?= $room['img']?>
        </div>
        <div class="hotel-room__data-block">
            <p class="hotel-room__hotel-name"><?= $room['hr_hotel_name'] ?></p>
            <p class="hotel-room__room-name"><?= $room['hr_room_name'] ?></p>
            <div class="hotel-room__information-line">
                <span class="hotel-room__information">$ <?= $room['hr_cost'] ?> usd/<?=__( 'night', HR_PLUGIN_SLUG )?></span>
                <span class="hotel-room__information"><?= $room['hr_rate'] ?> <?= __( 'star rate', HR_PLUGIN_SLUG ) ?></span>
            </div>
            <div class="hotel-room__date-line">
                <div class="hotel-room__date">
                    <p class="hotel-room__date-data"><?= __( 'Arrival', HR_PLUGIN_SLUG ) ?></p>
                    <p class="hotel-room__date-data"><?= date_i18n('F', strtotime($room['hr_arrival_date']))?></p>
                    <p class="hotel-room__date-value"><?= date('d', strtotime($room['hr_arrival_date']))?></p>
                </div>
                <div class="hotel-room__date">
                    <p class="hotel-room__date-data"><?= __( 'Departure', HR_PLUGIN_SLUG ) ?></p>
                    <p class="hotel-room__date-data"><?= date_i18n('F', strtotime($room['hr_departure_date']))?></p>
                    <p class="hotel-room__date-value"><?= date('d', strtotime($room['hr_departure_date']))?></p>
                </div>
            </div>
            <div class="hotel-room__icon-line">
                <span class="hotel-room__icon hotel-room__icon--adult"
                      title="<?= __( 'Adult count', HR_PLUGIN_SLUG ) ?>">
                    <span class="hotel-room__icon-text"><?= $room['hr_adult'] ?></span>
                </span>
                <span class="hotel-room__icon hotel-room__icon--child"
                      title="<?= __( 'Children count', HR_PLUGIN_SLUG ) ?>">
                    <span class="hotel-room__icon-text"><?= $room['hr_child'] ?></span>
                </span>
            </div>
        </div>
    </div>
<?php endforeach; ?>
