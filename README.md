# FoodBank
A website created for CPSC 471. This website allows employees (employees taking orders, employees packing orders, and supervisors) to efficient operate their food bank system. This application allows employees to create order reciepts for the logistics team to know what to put into each box. The application keeps track of logistics (inventory quantity, replenishment of inventory, etc.)
The sign in allows for THREE different types of employees to sign in: Employees taking orders, Employees fufilling orders, Supervisors (ADMINS).
Front employees can create food or clothing order sheets for families (depending on what they need) which will then be sent off to the back employees.
Back employees then can see what orders they have to fulfill and can check it off once they are done.
Supervisors can update and add foods/clothes to the database. They can also see the workers that they are supervising.

This website uses a PHP and Javascript, with a MySQL dattabase. Bootstrap was also used for the frontend.

LOGIN PAGE
![Login](https://github.com/user-attachments/assets/1db4fc68-0773-4869-914f-e4c238f5b90a)

CREATING FOOD ORDER
![employeeFood](https://github.com/user-attachments/assets/9e6cda13-a359-4eba-821d-111e1f7a88f1)

ORDER RECEIPTS
![previeworder](https://github.com/user-attachments/assets/76a7f6fb-7fd8-400e-a0e3-9d15110caa49)

ADDING/UDPATING FOOD INVENTORY
![adminaddfood](https://github.com/user-attachments/assets/7552ecc3-6d24-4fa7-92be-1d23859131f1)

In order to run this you must:
- Open XAMPP Control Panel
- Click the "start" button to run "Apache" module
- Click the "start" button to run "MySQL" module
- Open browser
- Go to: http://localhost/FoodBank/signin.php
