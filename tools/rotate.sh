for img in *
do
    echo -n "$img, orientation: "
    ROT=`exiftool "$img" | grep Orientation | cut -d' ' -f23-24`
    echo -n "$ROT"
    if [ "$ROT" == "Rotate 90" ]
    then
        echo "Rotated 90"
        mogrify -rotate 90 "$img"
    fi
    if [ "$ROT" == "Rotate 270" ]
    then
        echo "Rotated 270"
        mogrify -rotate -90 "$img"
    fi
    echo
done
