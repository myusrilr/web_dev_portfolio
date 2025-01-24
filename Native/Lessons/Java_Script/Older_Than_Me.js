// https://edabit.com/challenge/iwdZiFucR5wkQsFHu

class Person {
	constructor(name, age) {
		this.name = name;
		this.age = age;
	}

	compareAge(other) {
		if (this.age > other.age) {
			return `${other.name} is younger than me.`;
		} else if (this.age < other.age) {
			return `${other.name} is older than me.`;
		} else {
			return `${other.name} is the same age as me.`;
		}
		
	}

}

const p1 = new Person("Samuel", 24);
const p2 = new Person("Joel", 36);
const p3 = new Person("Lily", 24);

console.log(p1.compareAge(p2));
console.log(p2.compareAge(p1));
console.log(p1.compareAge(p3));