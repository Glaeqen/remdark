#!/usr/bin/python3

for i in range(1, 121):
    print(".w3-col.glaeqen-col-120.s" + str(i)+ " {")
    print("    width: {0:0.5f}%".format((100.0*i)/120))
    print("}")
