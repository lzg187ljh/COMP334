# COMP334
Online Library
Wellcome to my first database website with php and mySQL, this website contains several functionalities of an online library includes Sign in ,Sign out, Book borrowing,
Book returning, Pay fine, Search by keyword & category, User data Data analysis with Google api. This website uses class sr-only which is a Screen Readers to meet its
Accessibility requirement. To avoid copyright problem,the image inside this website are open source .

1.Responsive design:
I set up 2 designs for each page, for large screen:@media (min-width: 768px) and for mobile device: @media only screen and (max-width: 990px)
In the navigation bar a dropdown list will replace the list when the screen is small， In Report page, i used !important css rule to overwrite the orginial google api code
to make sure the image match the current sceen size. You may refresh the page when changing screen size from large to small

2.Two different level of users & Generating ticket
Both student and teacher 's account will generate a fine ticket when the book returning is overdue. the loan period for student is 30 days and for teacher is 120days.
However this part hard to test because if you return books short after borrowing books, no overdue ticket will be generated. For convenience purposes, in return_new.php(line 67),
i change the overdue condition for student from over 30 days to within 30 days.Therefore if you login as a student user, you will get an overdue ticket after returning book.
If you change the "<" sign in code "FROM Return_table WHERE return_date<adddate(borrow_date1,30)" (line 67) to ">". everything will go back to normal

3. Sign in & Sign up
I set up some accounts for testing:
User 1 [	Student	User id:1	Password:1]
User 2 [	Student	User id:2	Password:2]
User 3 [	Teacher	User id:7	Password:7]
User 4 [	Teacher	User id:10	Password:10]

the id column in mysql is a integer from 1 to 10
The data in Report page are based on these user's behaviour

4. Borrow & Return
User's privileges are 1 by default, if a user get more than 3 tickets, the user credit will change to 0, it means that this user cannot borrow more books unless he/she pay the fine.
In my database the User with id 7 has a credit of 0. 



