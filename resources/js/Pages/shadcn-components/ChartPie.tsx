import * as React from "react"
import { TrendingUp } from "lucide-react"
import { Label, Pie, PieChart } from "recharts"

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/Components/ui/card'
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/Components/ui/chart"

type VehicleDataItem = {
  vehicleType: string;
  registeredVehicles: number;
  fill: string;
}

type VehicleData = VehicleDataItem[];

type VehicleChartConfig = {
  registeredVehicles: {
    label: string;
  };
  [key: string]: {
    label: string;
    color: string;
  }|{label: string};
}

type VehicleChartProps = {
  vehicleData: VehicleData;
  vehicleChartConfig: VehicleChartConfig;
}

export function VehicleChart({ vehicleData, vehicleChartConfig }: VehicleChartProps) {
  const totalVehicles = React.useMemo(() => {
    return vehicleData.reduce((acc, curr) => acc + curr.registeredVehicles, 0)
  }, [vehicleData])

  return (
    <Card className="flex flex-col">
      <CardHeader className="items-center pb-0">
        <CardTitle>Vehicle Registration Chart</CardTitle>
        <CardDescription>Distribution of Registered Vehicles</CardDescription>
      </CardHeader>
      <CardContent className="flex-1 pb-0">
        <ChartContainer
          config={vehicleChartConfig}
          className="mx-auto aspect-square max-h-[250px]"
        >
          <PieChart>
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent hideLabel />}
            />
            <Pie
              data={vehicleData}
              dataKey="registeredVehicles"
              nameKey="vehicleType"
              innerRadius={60}
              strokeWidth={5}
            >
              <Label
                content={({ viewBox }) => {
                  if (viewBox && "cx" in viewBox && "cy" in viewBox) {
                    return (
                      <text
                        x={viewBox.cx}
                        y={viewBox.cy}
                        textAnchor="middle"
                        dominantBaseline="middle"
                      >
                        <tspan
                          x={viewBox.cx}
                          y={viewBox.cy}
                          className="fill-foreground text-3xl font-bold"
                        >
                          {totalVehicles.toLocaleString()}
                        </tspan>
                        <tspan
                          x={viewBox.cx}
                          y={(viewBox.cy || 0) + 24}
                          className="fill-muted-foreground"
                        >
                          {vehicleChartConfig.registeredVehicles.label}
                        </tspan>
                      </text>
                    )
                  }
                }}
              />
            </Pie>
          </PieChart>
        </ChartContainer>
      </CardContent>
      <CardFooter className="flex-col gap-2 text-sm">
        <div className="flex items-center gap-2 font-medium leading-none">
          Total registered vehicles: {totalVehicles} <TrendingUp className="h-4 w-4" />
        </div>
        <div className="leading-none text-muted-foreground">
          Showing distribution of all registered vehicles
        </div>
      </CardFooter>
    </Card>
  )
}
