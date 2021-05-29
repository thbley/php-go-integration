// rustc -C opt-level=3 ackermann.rs && time ./ackermann

fn ack(m: isize, n: isize) -> isize {
    if m == 0 {
        n + 1
    } else if n == 0 {
        ack(m - 1, 1)
    } else {
        ack(m - 1, ack(m, n - 1))
    }
}
 
fn main() {
    println!("{}", ack(3, 11));
}
