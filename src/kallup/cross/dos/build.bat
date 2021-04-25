windres main.rc main.obj
g++ -O2 -c main.cc -o main.o
g++ -I/e/srv/MyVisualdBase4WEB/src/kallup/cross/boost \
	-o main.exe main.o main.obj \
	-lcomctl32 -lgdi32
