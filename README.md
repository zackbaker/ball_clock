<h1> Ball Clock </h1>

<p>
	There was a few issues that I found with the ball clock project, one of which was trying to figure out why it would die on me halfway through the code.
</p>

<p>
	Come to find out PHP doesn't do too well with recursion. I had to make pretty much everything into one function which makes the code look quite sloppy, but it was either do it this way or it wouldn't work.
</p>

<p>
	With this knowledge I did try to design it in such a way that it is still very workable and easy to tell what is going on and found it quite a great learning experience about PHP's capabilities with recursion.
</p>

<p>
	In this repository I also have a vagrant box provisioning file that loads up Trusty64 (if you have problems with this I have also built in an easy way to turn it into Trusty32, just uncomment the line).
</p>