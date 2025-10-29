import { Input } from '@/components/ui/input';
import { useState } from "react";
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"

export default function InteractionInput() {

    const [serviceList, setServiceList] = useState([{ service: "" }]);

    const handleServiceChange = (e, index) => {
        const { name, value } = e.target;
        const list = [...serviceList];
        list[index][name] = value;
        setServiceList(list);
    };

    const handleServiceRemove = (index) => {
        const list = [...serviceList];
        list.splice(index, 1);
        setServiceList(list);
    };

    const handleServiceAdd = () => {
        setServiceList([...serviceList, { service: "" }]);
    };


    return (
        <>
        <div className="form-field">
            <label htmlFor="service">Interactions(s)</label>
            {serviceList.map((singleService, index) => (
                <div key={index} className="services">
                    <div className="first-division flex gap-2">
                        <Select name="interactions[][type]">
                            <SelectTrigger className="w-[180px]">
                                <SelectValue placeholder="Select a Interaction" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Interactions</SelectLabel>
                                    <SelectItem value="click">Click</SelectItem>
                                    <SelectItem value="hover">Hover</SelectItem>
                                    <SelectItem value="keyboard">keyboard</SelectItem>
                                    <SelectItem value="swipe">Swipe</SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <Input
                            name="interactions[][note]"
                            type="text"
                            placeholder="Interaction Note"
                        />
                    </div>
                    <div className="second-division">
                        {serviceList.length !== 1 && (
                            <Button
                                type="button"
                                onClick={() => handleServiceRemove(index)}
                                className="remove-btn"
                            >
                                <span>Remove</span>
                            </Button>
                        )}
                    </div>
                    <div>
                        {serviceList.length - 1 === index && serviceList.length < 5 && (
                            <Button
                                type="button"
                                onClick={handleServiceAdd}
                                className="add-btn"
                            >
                                <span>Add a Interaction</span>
                            </Button>
                        )}
                    </div>
                </div>
            ))}
        </div>
    </>
    );
}
