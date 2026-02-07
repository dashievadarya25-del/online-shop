<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<a href="/catalog">Каталог продуктов</a>
<h2>My orders</h2>
<div class="order-container">
    <?php foreach ($newUserOrders as $newUserOrder) : ?>
         <div class="order-cart">
             <h2> Заказ № <?php echo $newUserOrder['id']?></h2>
             <p><?php echo $newUserOrder['contact_name']?></p>
             <p><?php echo $newUserOrder['contact_phone']?></p>
             <p><?php echo $newUserOrder['comment']?></p>
             <p><?php echo $newUserOrder['address']?></p>
             <table>
             <thead>
                 <tr>
                     <th>Наименование</th>
                     <th>Количество</th>
                     <th>Стоимость</th>
                     <th>Сумма</th>
                 </tr>
             </thead>
                 <tbody>
                 <?php foreach ($newUserOrder['products'] as $newOrderProduct) : ?>
                 <tr>
                     <td><?php echo $newOrderProduct['name']?></td>
                     <td><?php echo $newOrderProduct['amount']?></td>
                     <td><?php echo $newOrderProduct['price']?></td>
                     <td><?php echo $newOrderProduct['totalSum']?></td>
                 </tr>
                 <?php endforeach; ?>
                 </tbody>
             </table>
            <p> Сумма заказа <?php echo $newUserOrder['total']?></p>
         </div>
    <?php endforeach; ?>
</div>

</body>
</html>