# Stock exchange platform
<p>These platform provides stock trade possibilities.
You can buy and sell stocks, also short buy and sell option.
Search stock you want, no restrictions. Manage your wallet by adding money, 
in your personal cabinet, from there you can manage your stocks and see transaction history. 
Also, possibility to transfer stock to another user.</p>

### Features:
<ol>
    <li>Search stocks worldwide</li>
    <li>Buy and sell stocks</li>
    <li>Short buy and sell option</li>
    <li>Personal cabinet</li>
    <li>Transfer stocks to another user</li>
</ol>

![](https://github.com/pentakostal/SomethingNew/blob/main/public/gif/Peek%202022-12-26%2009-19.gif)
![](https://github.com/pentakostal/SomethingNew/blob/main/public/gif/Peek%202022-12-26%2009-191.gif)
![](https://github.com/pentakostal/SomethingNew/blob/main/public/gif/Peek%202022-12-26%2009-20.gif)

### Components used:
<ol>
<li>PHP 7.4</li>
<li>MySql (8.0.31-0ubuntu0.22.04.1 (Ubuntu))</li>
<li>Other packages located in composer.lock file</li>
</ol>

### How to install
<ol>
<li>Clone repository to your local machine (more convenient way for you)</li>
<li>For these project you will need a API key from (register for free, and you will
get your API key): </li>

[Finnhub](https://finnhub.io/)

<li>After in console navigate to root folder, where you cloned project.</li>
<li>Then run command:</li>

> composer install

<li>Create a .env file
    <ol>
        <li>Take .env.example file and rename it in .env.</li>
        <li>Enter your data about database.</li>
        <li>Enter your api key.</li>
    </ol>
</li>
<li>Im root directory run command:</li>

>php -S localhost:8000

<li>After you can open project in your favorite browser under localhost:8000</li>
</ol>

