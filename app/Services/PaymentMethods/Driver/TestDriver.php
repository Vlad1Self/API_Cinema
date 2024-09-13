<?php

namespace App\Services\PaymentMethods\Driver;

use App\DTO\PaymentDTO\RedirectPaymentDTO;
use App\Models\Payment;

class TestDriver extends PaymentDriver
{
    /**
     * Создание платежа для тестового драйвера
     *
     * @param string $payment_uuid
     * @return Payment
     * @throws \Exception
     */
    public function createPayment(string $payment_uuid): Payment
    {
        // Генерация driver_payment_id (UUID для драйвера)
        $driver_payment_uuid = uuid_create();

        // Поиск платежа по UUID
        $payment = Payment::query()->where('uuid', $payment_uuid)->first();

        if (!$payment) {
            throw new \Exception('Payment not found');
        }

        // Присвоение driver_payment_id и сохранение
        $payment->driver_payment_id = $driver_payment_uuid;
        $payment->save();

        return $payment;
    }

    /**
     * Формирование редиректа в зависимости от валюты
     *
     * @param Payment $payment
     * @return RedirectPaymentDTO
     * @throws \Exception
     */
    public function redirect(Payment $payment): RedirectPaymentDTO
    {
        // Создание DTO для редиректа
        $data = new RedirectPaymentDTO([
            'payment_uuid' => $payment->uuid,
            'driver_payment_uuid' => $payment->driver_payment_id,
            'url' => ''
        ]);

        // Установка URL в зависимости от валюты платежа
        match ($payment->paymentMethod->name) {
            'testUSD' => $data->url = 'https://response_for_usd.com',
            'testRUB' => $data->url = 'https://response_for_rub.com',
            default => throw new \Exception('Invalid currency'),
        };

        return $data;
    }
}
